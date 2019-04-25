<?php


namespace Codex\Blog;


use Codex\Attributes\AttributeType as T;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;

class BlogAttributeExtension extends AttributeExtension
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        $blog = $registry->add('blog');
        $blog->parent($registry->codex);

        $blog->mergeKeys([]);
        $blog->inheritKeys([ 'processors', 'layout', 'cache' ]);
        $blog->child('inherits', T::ARRAY(T::STRING) );
        $blog->child('changes', T::MAP );
        $blog->child('default_category', T::STRING, 'ID!');


        $categories = $registry->add('categories');
        $categories->parent($blog);
        $categories->mergeKeys([]);
        $categories->inheritKeys([ 'processors', 'layout', 'cache' ]);


        $posts = $registry->add('posts');
        $posts->parent($categories);
        $posts->mergeKeys([]);
        $posts->inheritKeys([ 'processors', 'layout', 'cache' ]);

    }
}
