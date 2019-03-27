<?php

namespace Codex\Packagist;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;

class PackagistAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-packagist' ];

    public $singletons = [
    ];

    public $extensions = [
    ];


    public function register()
    {
    }

    public function boot(AttributeDefinitionRegistry $registry)
    {
    }
}
