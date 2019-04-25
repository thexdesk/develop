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

    public $extensions = [
        GitAttributeExtension::class
    ];

    public function register()
    {
        Hooks::register(['project.resolved','revision.resolved','document.resolved'], function (\Codex\Contracts\Models\Model $project) {
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
