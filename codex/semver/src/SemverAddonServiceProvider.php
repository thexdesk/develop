<?php

namespace Codex\Semver;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Git\Support\GitRevisionCollectionMixin;
use Codex\Revisions\RevisionCollection;

class SemverAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-semver' ];

    public function register()
    {
        $a = 'a';
        RevisionCollection::mixin(new GitRevisionCollectionMixin());

    }

    public function boot(AttributeDefinitionRegistry $registry)
    {
        $projects = $registry->projects;

        $semver = $projects->add('semver', 'dictionary', 'ProjectSemverConfig')->setDefault([]);
        $semver->add('production_branch', 'string')->setDefault('master');


        collect($this->app['config']['codex-semver.default_project_config'])->each(function($value, $key){
            $this->app['config']->set('codex.projects.' . $key, $value);
        });

    }
}
