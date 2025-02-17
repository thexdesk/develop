<?php


return [
    'display_name' => 'Codex',
    'description'  => 'Codex is a file-based documentation system build with Laravel 5.5',

    'processors' => [
        'enabled' => [
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
    ],

    'default_revision' => \Codex\Git\BranchType::PRODUCTION,

    'disk' => 'codex-ftp-git-project',

    'git' => [
        'enabled' => true,

        'remotes' => [
            'develop' => [
                // The connection key to use (as defined at the top of this file)
                'connection' => 'github_token',
                // The owner (organisation or username)
                'owner'      => 'codex-project',
                // The repository name
                'repository' => 'develop',
                // repository url
                'url'        => 'https://github.com/%s/%s',

                'document_url' => 'https://github.com/%s/%s/tree/%s',

                'webhook' => [
                    // Enable webhook support. Configure it in Github/Bitbucket.
                    // This will automaticly sync your project every time a 'push' event occurs
                    // This also requires you to configure queues properly (by using for example, redis with supervisord)
                    'enabled' => true,

                    // Github webhooks allow a 'secret' that has to match. Put it in here
                    'secret'  => null,
                ],
            ],
            'core'    => [
                // The connection key to use (as defined at the top of this file)
                'connection' => 'github_token',
                // The owner (organisation or username)
                'owner'      => 'codex-project',
                // The repository name
                'repository' => 'core',
                // repository url
                'url'        => 'https://github.com/%s/%s',

                'document_url' => 'https://github.com/%s/%s/tree/%s',

                'webhook' => [
                    // Enable webhook support. Configure it in Github/Bitbucket.
                    // This will automaticly sync your project every time a 'push' event occurs
                    // This also requires you to configure queues properly (by using for example, redis with supervisord)
                    'enabled' => true,

                    // Github webhooks allow a 'secret' that has to match. Put it in here
                    'secret'  => null,
                ],
            ],
        ],
        'syncs'   => [
            [
                'remote'   => 'develop',
                // Branches to sync
                'branches' => [
                    'master' => 'v1',
                ],
                // Version (tags) constraints makes one able to define ranges and whatnot
                // * || 1.x || >=2.5.0 || 5.0.0 - 7.2.3'
                'versions' => null,

                'skip' => [
                    'patch_versions' => false,
                    'minor_versions' => false,
                ],

                'copy' => [
                    'resources/docs/codex/v1/**/*.md',
                    'resources/docs/codex/v1/revision.yml' => 'revision.yml',
                ],
            ],
            [
                'remote'   => 'core',
                // Branches to sync
                'branches' => [ 'master' ], //[ 'master']
                // Version (tags) constraints makes one able to define ranges and whatnot
                // * || 1.x || >=2.5.0 || 5.0.0 - 7.2.3'
                'versions' => null,

                'skip' => [
                    'patch_versions' => false,
                    'minor_versions' => false,
                ],

                'copy' => [
                    'resources/docs/**/*.md',
                    'resources/docs/revision.yml' => 'revision.yml',
                    'resources/docs/index.md'     => 'index.md',
                ],
            ],
        ],
        'links'   => [
            'enabled' => true,
            'remote'  => '%revision.key%',
        ],
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
