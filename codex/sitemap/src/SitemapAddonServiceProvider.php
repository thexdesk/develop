<?php
namespace Codex\Sitemap;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Console\GenerateSitemapCommand;

class SitemapAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-sitemap' ];

    public $commands = [
        Console\GenerateSitemapCommand::class
    ];

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
