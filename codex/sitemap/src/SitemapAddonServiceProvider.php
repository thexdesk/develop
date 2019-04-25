<?php

namespace Codex\Sitemap;

use Codex\Addons\AddonServiceProvider;

class SitemapAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-sitemap' ];

    public $commands = [
        Console\GenerateSitemapCommand::class,
    ];

    public $extensions = [
        SitemapAttributeExtension::class,
    ];

    public function register()
    {
    }

}
