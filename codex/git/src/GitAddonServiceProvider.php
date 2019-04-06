<?php

namespace Codex\Git;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Documents\Document;
use Codex\Git\Listeners\ResolveBranchTypeDefaultRevision;
use Codex\Git\Support\GitRevisionCollectionMixin;
use Codex\Hooks;
use Codex\Projects\Events\ResolvedProject;
use Codex\Projects\Project;
use Codex\Revisions\Revision;
use Codex\Revisions\RevisionCollection;
use Illuminate\Contracts\Foundation\Application;

class GitAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-git' ];

    public $mapConfig = [
        'codex-git.default_project_config.branching' => 'codex.projects.branching',
        'codex-git.default_project_config.git'       => 'codex.projects.git',
        'codex-git.default_project_config.git_links'       => 'codex.projects.git_links',
    ];

    public $listen = [
        ResolvedProject::class => [
            ResolveBranchTypeDefaultRevision::class,
        ],
    ];

    public $commands = [
        Console\CodexGitSyncCommand::class,
    ];

    public function register()
    {
//        Hooks::register('project.initialized', function (\Codex\Contracts\Projects\Project $project) {
//            if ($project->isGitEnabled()) {
//                $project->push('git_links', config('codex-git.default_project_config.git_links'));
//            }
//        });
        Hooks::register(['project.resolved','revision.resolved','document.resolved'], function (\Codex\Contracts\Mergable\Model $project) {
            $project->addGetMutator('git.connection_config', function () {
                /** @var \Codex\Contracts\Projects\Project $this */
                return $this->git()->getManager()->getConnectionConfig($this->git()->getConnection());
            });
        });
        Hooks::register('document.resolved', function (\Codex\Contracts\Documents\Document $document) {
            if ( ! $document->isGitLinksEnabled()) {
                return;
            }
            $map   = $document->attr('git_links.map', []);
            $links = $document->attr('git_links.links', []);
            foreach ($map as $linkKey => $attrKey) {
                $method = 'push';
                if (false !== strpos($linkKey, ':')) {
                    list($linkKey, $method) = explode(':', $linkKey);
                }
                $link = $links[ $linkKey ];
                if ($method === 'set') {
                    $document->set($attrKey, $link);
                } elseif ($method === 'push') {
                    $document->push($attrKey, $link);
                }
            }
            $document->addGetMutator('git_links.document_url', function () {
                /** @var \Codex\Contracts\Documents\Document $document */
                $document = $this;
                return $document->git()->getDocumentUrl($document->getPath());
            });
        });
        $this->registerMacros();
        $this->registerManager();
    }

    public function attributes(AttributeDefinitionRegistry $registry)
    {
        $projects = $registry->projects;

        $semver = $projects->add('branching', 'dictionary')->setApiType('BranchingConfig', [ 'new' ]);
        $semver->add('production', 'string')->setDefault('master');
        $semver->add('development', 'string')->setDefault('develop');
        $git = $projects->add('git', 'dictionary')->setApiType('GitConfig', [ 'new' ]);
        $git->add('enabled', 'boolean')->setDefault(false);
        $git->add('owner', 'string');
        $git->add('repository', 'string');
        $git->add('connection', 'string');
        $git->add('branches', 'array.scalarPrototype');
        $git->add('versions', 'string');
        $skip = $git->add('skip', 'dictionary');
        $skip->add('patch_versions', 'boolean');
        $skip->add('minor_versions', 'boolean');
        $paths = $git->add('paths', 'dictionary');
        $paths->add('docs', 'string');
        $paths->add('index', 'string');
        $webhook = $git->add('webhook', 'dictionary');
        $webhook->add('enabled', 'boolean');
        $webhook->add('secret', 'string')->noApi();

        $git_links = $projects->add('git_links', 'dictionary')->setApiType('GitLinksConfig', [ 'new' ]);
        $git_links->add('enabled', 'boolean');
        $git_links->add('map', 'array.scalarPrototype', 'Assoc',[]);
        $git_links->add('links', 'dictionaryPrototype', '[Assoc]',[]);

        $registry->revisions->addInheritKeys(['git','git_links']);
        $registry->documents->addInheritKeys(['git','git_links']);
    }

    protected function registerMacros()
    {
        RevisionCollection::mixin(new GitRevisionCollectionMixin());

        Project::macro('git', function () {
            return $this->storage('git', function ($model) {
                return new GitConfig($model, app('codex.git.manager'));
            });
        });
        Revision::macro('git', function () {
            return $this->getProject()->git();
        });
        Document::macro('git', function () {
            return $this->getProject()->git();
        });

        Project::macro('isGitEnabled', function () {
            return $this->attr('git.enabled', false);
        });
        Revision::macro('isGitEnabled', function () {
            return $this->getProject()->attr('git.enabled', false);
        });
        Document::macro('isGitEnabled', function () {
            return $this->getProject()->attr('git.enabled', false);
        });
        Project::macro('isGitLinksEnabled', function () {
            return $this->attr('git_links.enabled', false);
        });
        Revision::macro('isGitLinksEnabled', function () {
            return $this->attr('git_links.enabled', false);
        });
        Document::macro('isGitLinksEnabled', function () {
            return $this->attr('git_links.enabled', false);
        });
    }

    protected function registerManager()
    {
        $this->app->singleton('codex.git.manager', function (Application $app) {
            $manager = new ConnectionManager($app[ 'config' ]);
            $manager->extend('bitbucket', function ($config) {
                return new Drivers\BitbucketDriver($config);
            });
            $manager->extend('github', function ($config) {
                return new Drivers\GithubDriver($config);
            });

            return $manager;
        });
        $this->app->alias('codex.git.manager', ConnectionManager::class);
        $this->app->alias('codex.git.manager', Contracts\ConnectionManager::class);
    }
}
