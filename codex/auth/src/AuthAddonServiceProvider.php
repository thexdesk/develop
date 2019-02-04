<?php

/** @noinspection RepetitiveMethodCallsInspection */

namespace Codex\Auth;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Codex;
use Codex\Exceptions\NotFoundException;
use Codex\Hooks;
use Codex\Projects\Project;
use Gate;

class AuthAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-auth' ];

    public $mapConfig = [ 'codex-auth.default_project_config' => 'codex.projects' ];

    protected $viewDirs = [ 'views' => 'codex-auth' ];

    protected $migrationDirs = [ 'migrations' ];

    protected $publishMigrations = true;

    public $providers = [
        Http\HttpServiceProvider::class,

    ];

    public $extensions = [
        Api\AuthSchemaExtension::class,
    ];

    public function register()
    {
        $this->registerRouteMapConfig();
        $this->registerClassMacros();
        $this->restrictApiResults();
        $this->addAccountMenuItem();
    }

    public function boot(AttributeDefinitionRegistry $registry)
    {

        $urls = $registry->codex->getChild('urls');
        $urls->add('auth_login_callback', 'string');
        $urls->add('auth_login', 'string');
        $urls->add('auth_logout', 'string');


        $projects = $registry->projects;
        $auth     = $projects->add('auth', 'dictionary')->setApiType('AuthConfig', [ 'new' ]);
        $auth->add('enabled', 'boolean');
        $with = $auth->add('with', 'array.arrayPrototype')->noApi();
        $with->add('service', 'string');
        $with->add('groups', 'array.scalarPrototype');
        $with->add('emails', 'array.scalarPrototype');
        $with->add('usernames', 'array.scalarPrototype');
    }

    protected function registerRouteMapConfig()
    {
        $config = $this->app->make('config');
        $config->set('codex.routeMap.auth_login_callback', 'codex.auth.login.callback');
        $config->set('codex.routeMap.auth_login', 'codex.auth.login');
        $config->set('codex.routeMap.auth_logout', 'codex.auth.logout');
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
        Hooks::register('CodexQueries::projects', /** @param \Codex\Projects\ProjectCollection $projects */
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
        Hooks::register('CodexQueries::project', /** @param \Codex\Contracts\Projects\Project $project */
            function ($project) {
                if ($project->auth()->isEnabled() && $project->auth()->hasAccess() !== true) {
                    throw NotFoundException::project($project)->toApiError();
                }
                return $project;
            });
    }

    protected function addAccountMenuItem()
    {
        $menuId = md5(str_random());
        config()->push('codex.layout.header.menu', [
            'id'       => $menuId,
            'label'    => 'Account',
            'sublabel' => 'Guest',
            'type'     => 'sub-menu',
            'icon'     => 'user',
            'renderer' => 'big',
            'children' => [],
        ]);

        Hooks::register('GetBackendData', function ($data) use ($menuId) {
            $index = null;
            foreach (data_get($data, 'codex.layout.header.menu', []) as $i => $item) {
                if ($item[ 'id' ] === $menuId) {
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
//                codex()->auth()->getProvider($service)->stateless()
                if ($loggedIn) {
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
