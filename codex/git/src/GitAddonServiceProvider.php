<?php

namespace Codex\Git;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Git\Listeners\ResolveBranchTypeDefaultRevision;
use Codex\Git\Support\GitRevisionCollectionMixin;
use Codex\Projects\Events\ResolvedProject;
use Codex\Projects\Project;
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
        Console\CodexGitSyncCommand::class,
    ];

    public function register()
    {
        RevisionCollection::mixin(new GitRevisionCollectionMixin());

        Project::macro('getGitConfig', function () {
            /** @var Project $project */
            $project = $this;
            return new ProjectGitConfig($project, app('codex.git.manager'));
        });

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
        $webhook->add('secret', 'string');
    }
}
