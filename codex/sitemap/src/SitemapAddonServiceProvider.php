<?php
namespace Codex\Sitemap;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;

class SitemapAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-sitemap' ];

    public function register()
    {
    }

    public function boot(AttributeDefinitionRegistry $registry)
    {
//        $projects = $registry->projects;
//        $addon = $projects->add('sitemap', 'dictionary')->setApiType('SitemapConfig', [ 'new' ]);
//        $addon->add('enabled', 'boolean');
    }
}
