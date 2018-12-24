<?php


return [
    'display_name' => 'Codex',
    'description'  => 'Codex is a file-based documentation system build with Laravel 5.5',
    'meta'         => [
        'icon'     => 'fa-book',
        'color'    => 'deep-orange',
        'author'   => 'Robin Radic',
        'license'  => 'MIT',
        'websites' => [
            'vcs'     => 'https://github.com/codex-project',
            'issues'  => 'https://github.com/codex-project/codex/issues',
            'package' => 'https://packagist.com/codex-project/codex',
        ],
    ],

    'processors' => [
        'enabled'    => [ 'attributes', 'parser', 'toc', 'header', 'macros', 'buttons', 'links', 'phpdoc' ],
        'attributes' => [
            'tags' => [
                [ 'open' => '<!--*', 'close' => '--*>' ], // html, markdown
                [ 'open' => '---', 'close' => '---' ], // markdown (frontmatter)
                [ 'open' => '\*', 'close' => '*/' ], // codex v1 style
            ],
        ],
        'toc'        => [
            'header_link_show' => true,
        ],
    ],

    'revision' => [
        'default' => \Codex\Git\BranchType::LAST_VERSION,
//        'default' => \Codex\Git\BranchType::PRODUCTION,
//        'default' => \Codex\Git\BranchType::DEVELOPMENT,
    ],

    'phpdoc' => [
        'enabled'       => true,
        'default_class' => 'Codex\\Codex',
    ],

    'git' => [
        'enabled'    => true, /// local symlink
        'owner'      => 'codex-project',
        'repository' => 'core',
        'connection' => 'bitbucket_oauth',
        'sync'       => [
            'branches' => [ 'master' ],
            'versions' => '>=2.0.0', //1.x || >=2.5.0 || 5.0.0 - 7.2.3'
            'paths'    => [
                'docs'  => 'resources/docs',
                'index' => 'resources/docs/index.md',
            ],
        ],
        'webhook'    => [
            'enabled' => true,
        ],
    ],
];
