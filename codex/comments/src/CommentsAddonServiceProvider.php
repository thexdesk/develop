<?php

namespace Codex\Comments;

use Codex\Addons\AddonServiceProvider;
use Codex\Comments\Drivers\DisqusDriver;

class CommentsAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-comments' ];

    public $singletons = [
        CommentsManager::class => CommentsManager::class,
    ];

    public $extensions = [
        Documents\CommentsProcessorExtension::class,
        CommentsAttributeExtension::class
    ];

    public function register()
    {
    }

    public function boot()
    {
        $manager = resolve(CommentsManager::class);
        $manager->extend('disqus', function ($config) {
            $driver = new DisqusDriver($config);
            return $driver;
        });

        app('router')->get('comments/script')
            ->prefix(codex()->attr('http.prefix'))
            ->name('codex.comments.script')
            ->uses(CommentsScriptController::class . '@getScript');
    }
}
