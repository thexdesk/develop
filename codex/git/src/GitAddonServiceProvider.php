<?php

namespace Codex\Git;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Git\Listeners\ResolveBranchTypeDefaultRevision;
use Codex\Git\Support\GitRevisionCollectionMixin;
use Codex\Projects\Events\ResolvedProject;
use Codex\Revisions\RevisionCollection;
use Illuminate\Contracts\Foundation\Application;

class GitAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-git' ];

    public $mapConfig = [
        'codex-git.default_project_config' => 'codex.projects',
    ];

    public $listen = [
        ResolvedProject::class => [
            ResolveBranchTypeDefaultRevision::class,
        ],
    ];

    public $commands = [
        Console\CodexGitSyncCommand::class
    ];

    public function register()
    {
        RevisionCollection::mixin(new GitRevisionCollectionMixin());


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

    public function boot(AttributeDefinitionRegistry $registry)
    {
        $projects = $registry->projects;

        $semver = $projects->add('branching', 'dictionary')->setApiType('BranchingConfig', [ 'new' ]);
        $semver->add('production', 'string')->setDefault('master');
        $semver->add('development', 'string')->setDefault('develop');
    }
}
