<?php

namespace Codex\Blog;

use Codex\Addons\AddonServiceProvider;
use Codex\Codex;
use Codex\Hooks;
use Codex\Models\Commands\MergeAttributes;

class BlogAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-blog' ];

    public $singletons = [
//        Blog::class => Blog::class,
        Contracts\Blog::class => Blog::class,
    ];

    public $bindings = [
        'codex.blog'                         => Contracts\Blog::class,  //        Contracts\Blog::class => Blog::class
        Contracts\Categories\Category::class => Categories\Category::class,
        Contracts\Posts\Post::class          => Posts\Post::class,
    ];

    public $extensions = [
        BlogAttributeExtension::class,
    ];

    public function register()
    {
        Codex::macro('getBlog', function () {
            return resolve('codex.blog');
        });
        Hooks::register('blog.initialized', function ($blog) {
            $this->dispatch(new MergeAttributes($blog));
        });
    }
}
