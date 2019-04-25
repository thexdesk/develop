<?php

namespace Codex\Packagist;

use Codex\Addons\AddonServiceProvider;

class PackagistAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-packagist' ];

    public $extensions = [
        PackagistAttributeExtension::class,
    ];


    public function register()
    {
    }
}
