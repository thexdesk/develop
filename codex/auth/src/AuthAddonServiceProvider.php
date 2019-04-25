<?php

/** @noinspection RepetitiveMethodCallsInspection */

namespace Codex\Auth;

use Codex\Addons\AddonServiceProvider;
use Codex\Codex;
use Codex\Exceptions\NotFoundException;
use Codex\Hooks;
use Codex\Projects\Project;

class AuthAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-auth' ];

    public $mapConfig = [ 'codex-auth.default_project_config' => 'codex.projects' ];

    protected $viewDirs = [ 'views' => 'codex-auth' ];

    public $providers = [
        Http\HttpServiceProvider::class,

    ];

    public $extensions = [
        Api\AuthSchemaExtension::class,
        AuthAttributeExtension::class,
    ];

    public function register()
    {
        $this->registerRouteMapConfig();
        $this->registerClassMacros();
        $this->restrictApiResults();
        $this->addAccountMenuItem();
    }

    protected function registerRouteMapConfig()
    {
        Hooks::register('codex.urls.map', function ($map) {
            $map[ 'auth_login_callback' ] = 'codex.auth.login.callback';
            $map[ 'auth_login' ]          = 'codex.auth.login';
            $map[ 'auth_logout' ]         = 'codex.auth.logout';
            return $map;
        });
    }

    protected function registerClassMacros()
    {
        Codex::macro('auth', function ($remake = false) {
            /** @var Codex $codex */
            $codex   = $this;
            $storage = $codex->getStorage();
            if ($remake || ! $storage->has('phpdoc')) {
                $storage->put('auth', app()->make(CodexAuth::class, compact('codex')));
            }
            return $storage->get('auth');
        });
        Project::macro('auth', function ($remake = false) {
            /** @var Project $project */
            $project = $this;
            $storage = $project->getStorage();
            if ($remake || ! $storage->has('phpdoc')) {
                $storage->put('auth', app()->make(ProjectAuth::class, compact('project')));
            }
            return $storage->get('auth');
        });
    }

    protected function restrictApiResults()
    {
        Hooks::register('api.queries.projects', /** @param \Codex\Projects\ProjectCollection $projects */
            function ($projects, $rootValue, $args, $context, $resolveInfo) {
                $projects = $projects->filter(function (\Codex\Contracts\Projects\Project $project) {
                    if ( ! $project->auth()->isEnabled()) {
                        return true;
                    }
                    if ( ! $project->auth()->hasAccess()) {
                        return false;
                    }
                    return true;
                });
                return $projects;
            });
        Hooks::register('api.queries.get.project', /** @param \Codex\Contracts\Projects\Project $project */
            function ($project) {
                if ($project->auth()->isEnabled() && $project->auth()->hasAccess() !== true) {
                    throw NotFoundException::project($project)->toApiError();
                }
                return $project;
            });
    }

    protected function addAccountMenuItem()
    {
        config()->push('codex.layout.header.menu', [
            'id'       => md5(str_random()),
            'label'    => 'Account',
            'sublabel' => 'Guest',
            'type'     => 'sub-menu',
            'icon'     => 'user',
            'renderer' => 'big',
            'children' => [],
        ]);

        Hooks::register('commands.get_backend_data.response', function ($data) {
            $index = null;
            foreach (data_get($data, 'codex.layout.header.menu', []) as $i => $item) {
                if ($item[ 'label' ] === 'Account') {
                    $index = $i;
                    break;
                }
            }
            if ($index === null) {
                return $data;
            }
            $children = [];
            foreach (config('codex-auth.services', []) as $service => $config) {
                $loggedIn = codex()->auth()->isLoggedIn($service);
                if ($loggedIn) {
                    data_set($data, "codex.layout.header.menu.{$index}.sublabel", $service);
                    $user       = codex()->auth()->user($service);
                    $children[] = [
                        'label' => "Logout {$user['nickname']} from {$service}",
                        'type'  => 'link',
                        'href'  => url()->route('codex.auth.logout', compact('service')),
                    ];
                } else {
                    $children[] = [
                        'label' => 'Login with ' . $service,
                        'type'  => 'link',
                        'href'  => url()->route('codex.auth.login', compact('service')),
                    ];
                }
            }
            data_set($data, "codex.layout.header.menu.{$index}.children", $children);
            return $data;
        });
    }
}
