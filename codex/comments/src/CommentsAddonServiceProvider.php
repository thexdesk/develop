<?php

namespace Codex\Comments;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Comments\Drivers\DisqusDriver;

class CommentsAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-comments' ];

    public $singletons = [
        CommentsManager::class => CommentsManager::class,
    ];

    public $extensions = [
        Documents\CommentsProcessorExtension::class,
    ];


    public function register()
    {
    }

    public function boot(AttributeDefinitionRegistry $registry)
    {
        $manager = resolve(CommentsManager::class);
        $manager->extend('disqus', function ($config) {
            $driver = new DisqusDriver($config);
            return $driver;
        });

        $comments = $registry->documents->add('comments', 'dictionary')->setApiType('DocumentCommentsConfig', [ 'new' ]);
        $comments->add('enabled', 'boolean')->setDefault(false);
        $comments->add('driver', 'string');
        $comments->add('connection', 'string');

        app('router')->get('comments/script')
            ->prefix(codex()->attr('http.prefix'))
            ->name('codex.comments.script')
            ->uses(CommentsScriptController::class . '@getScript');
    }
}
