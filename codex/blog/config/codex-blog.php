<?php

return [
    'paths' => [
        'blog' => resource_path('blog'),
    ],

    'default_category' => 'general',


    // Extend/override inherited config from codex
    'processors'       => [],
    'layout'           => [],
    'cache'            => [],

    // default attributes for categories
    'categories'       => [
        'view' => 'codex-blog::category',
    ],

    // default attributes for posts
    'posts'            => [
        'view' => 'codex-blog::post',
    ],
];
