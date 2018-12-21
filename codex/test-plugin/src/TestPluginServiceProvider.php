<?php

namespace Codex\TestPlugin;

use Codex\Documents\Events\ResolvedDocument;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class TestPluginServiceProvider extends ServiceProvider
{
    protected $listen = [
        ResolvedDocument::class => [
            AddDocumentCallbacks::class
        ]
    ];

    public function register()
    {

    }
}
