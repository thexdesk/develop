<?php

namespace Codex\Blog;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Codex;
use Codex\Hooks;
use Codex\Mergable\Commands\MergeAttributes;

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

    public function register()
    {
        Codex::macro('getBlog', function () {
            return resolve('codex.blog');
        });
        Hooks::register('blog.initialized', function ($blog) {
            $this->dispatch(new MergeAttributes($blog));
        });
    }

    public function boot(AttributeDefinitionRegistry $registry)
    {
        $blog = $registry->addGroup('blog');
        $blog->setParentGroup($registry->codex);

        $blog->addMergeKeys([]);
        $blog->addInheritKeys([ 'processors', 'layout', 'cache' ]);
        $blog->add('inherits', 'array.scalarPrototype', '[String]');
        $blog->add('changes', 'dictionary', 'Assoc');
        $blog->add('default_category', 'string', 'ID!');


        $categories = $registry->addGroup('categories');
        $categories->setParentGroup($blog);
        $categories->addMergeKeys([]);
        $categories->addInheritKeys([ 'processors', 'layout', 'cache' ]);


        $posts = $registry->addGroup('posts');
        $posts->setParentGroup($categories);
        $posts->addMergeKeys([]);
        $posts->addInheritKeys([ 'processors', 'layout', 'cache' ]);

//        $projects = $registry->projects;
//        $addon = $projects->add('blog', 'dictionary')->setApiType('BlogConfig', [ 'new' ]);
//        $addon->add('enabled', 'boolean');
    }
}
