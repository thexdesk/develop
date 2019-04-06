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

    'processors'   => [
        'enabled'    => [
            'attributes' => true,
            'parser'     => true,
            'toc'        => true,
            'header'     => true,
            'macros'     => true,
            'links'      => true,
            'phpdoc'     => true,
            'cache'      => true,
            'buttons'    => true,
            'comments'   => false,
        ],
        'comments'   => [
            'connection' => 'disqus',
        ],
        'attributes' => [
            'tags' => [
                [ 'open' => '<!--*', 'close' => '--*>' ], // html, markdown
                [ 'open' => '<!---', 'close' => '-->' ], // html, markdown
                [ 'open' => '---', 'close' => '---' ], // markdown (frontmatter)
                [ 'open' => '\*', 'close' => '*/' ], // codex v1 style
            ],
        ],
        'toc'        => [
            'header_link_show' => true,
        ]
    ],

    'default_revision' => \Codex\Git\BranchType::PRODUCTION,

    'layout' => [
        'toolbar' => [
            'right' => [
                [
                    'component'  => 'c-button',
                    'borderless' => true,
                    'type'       => 'toolbar',
                    'icon'       => 'star',
                    'children'   => 'Packagist',
                    'target'     => '_black',
                    'title'      => 'Go to packagist package page',
                    'href'       => 'https://packagist.org/packages/codex/codex',
                ],
            ],
        ],
    ],

    'phpdoc' => [
        'enabled'       => true,
        'default_class' => 'Codex\\Codex',
    ],

    'git'       => [
        'enabled'    => true,
        'connection' => 'bitbucket_password',
        'owner'      => 'codex-project',
        'repository' => 'graph',
        'branches'   => [], //[ 'master']
        'paths'      => [
            'docs' => 'develop/resources/docs/codex',
        ],
    ],
    'git_links' => [
        'enabled' => true,
//        'map'     => [
//            'edit_page' => 'layout.toolbar.right', // push attribute to array (default)
//        ],
//        'links'   => [
//            'edit_page' => [
//                'component'  => 'c-button',
//                'borderless' => true,
//                'type'       => 'toolbar',
//                'icon'       => '%git.connection_config%',
//                'children'   => 'Edit Page',
//                'title'      => 'Edit this page',
//                'target'     => '_black',
//                'href'       => '%git_links.document_url%'
//            ],
//        ],
    ],
];


//    'layout' => [
//        'header' => [
//            'menu' => [
//                [
//                    'label' => 'Projects',
//                    'projects' => true,
//                    'type' => 'side-menu',
//                    'side' => 'right'
//                ],
//                [
//                    'label' => 'Revisions',
//                    'revisions' => true,
//                    'type' => 'side-menu',
//                    'side' => 'right'
//                ]
//            ]
//        ]
//    ],
