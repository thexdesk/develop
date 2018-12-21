<?php

namespace App\Attributes;

use Illuminate\Support\ServiceProvider;

class AttributeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AttributeRegistry::class);
    }

}
