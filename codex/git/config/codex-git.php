<?php

return [
    'connections' => [
        'bitbucket_oauth'    => [
            'driver' => 'bitbucket',
            'method' => 'token',
            'key'    => env('CODEX_GIT_BITBUCKET_KEY', 'your-key'),
            'secret' => env('CODEX_GIT_BITBUCKET_SECRET', 'your-secret'),
        ],
        'bitbucket_password' => [
            'driver'   => 'bitbucket',
            'method'   => 'password',
            'username' => env('CODEX_GIT_BITBUCKET_USERNAME', 'your-username'),
            'password' => env('CODEX_GIT_BITBUCKET_PASSWORD', 'your-password'),
        ],
        'github_token'       => [
            'driver' => 'github',
            'method' => 'token',
            'token'  => env('CODEX_GIT_GITHUB_TOKEN', 'your-token'),
        ],
        'github_password'    => [
            'driver'   => 'github',
            'method'   => 'password',
            'username' => env('CODEX_GIT_GITHUB_USERNAME', 'your-username'),
            'password' => env('CODEX_GIT_GITHUB_PASSWORD', 'your-password'),
        ],
        'github_app'         => [
            'driver'       => 'github',
            'clientId'     => 'your-client-id',
            'clientSecret' => 'your-client-secret',
            'method'       => 'application',
        ],
        'github_jwt'         => [
            'driver' => 'github',
            'token'  => 'your-jwt-token',
            'method' => 'jwt',
        ],
    ],

    'default_project_config' => [
        'branching' => [
            'production'  => 'master',
            'development' => 'develop',
        ],


        'git' => [
            'enabled' => false,
            'remotes' => [
                /*
                'main' => [
                    // The connection key to use (as defined at the top of this file)
                    'connection' => '',
                    // The owner (organisation or username)
                    'owner'      => '',
                    // The repository name
                    'repository' => '',
                    // repository url
                    'url'        => 'https://bitbucket.org/%s/%s',

                    'document_url' => 'https://bitbucket.org/%s/%s/src/%s',

                    'webhook' => [
                        // Enable webhook support. Configure it in Github/Bitbucket.
                        // This will automaticly sync your project every time a 'push' event occurs
                        // This also requires you to configure queues properly (by using for example, redis with supervisord)
                        'enabled' => false,

                        // Github webhooks allow a 'secret' that has to match. Put it in here
                        'secret'  => null,
                    ],
                ],
                */
            ],
            'syncs'   => [
                /*
                [
                    'remote'   => 'main',
                    // Branches to sync
                    'branches' => [], //[ 'master']
                    // Version (tags) constraints makes one able to define ranges and whatnot
                    // * || 1.x || >=2.5.0 || 5.0.0 - 7.2.3'
                    'versions' => null,

                    'skip' => [
                        'patch_versions' => false,
                        'minor_versions' => false,
                    ],

                    'clean' => [

                    ],

                    'copy' => [
                        'docs',
                        'docs/ ** /*.md',
                        'docs/index.md' => 'index.md',
                        'README.md'     => 'index.md',
                    ],
                ],
                */
            ],
            'links'   => [
                'enabled' => false,
                'remote'  => 'main',
                'map'     => [
                    'edit_page' => 'layout.toolbar.right', // push attribute to array (default)
//                'edit_page:push' => 'layout.toolbar.right', // push attribute to array (default)
//                'edit_page:set'  => 'layout.toolbar.right', // set attribute
//                'edit_page'      => false, // disable button
                ],
                'links'   => [
                    'edit_page' => [
                        'component'  => 'c-button',
                        'borderless' => true,
                        'target'     => '_black',
                        'type'       => 'toolbar',
                        /** git.connection_config is a get modifier in Document @see \Codex\Git\GitAddonServiceProvider */
//                        'icon'       => '%remote.connection.driver%',
                        'children'   => 'Edit Page',
                        /** git_links.document_url is a get modifier in Document @see \Codex\Git\GitAddonServiceProvider */
//                        'href'       => '%remote.document_url%',
                    ],
                ],
            ],
        ],

        'git_links' => [
            'enabled' => false,
            'map'     => [
                'edit_page' => 'layout.toolbar.right', // push attribute to array (default)
//                'edit_page:push' => 'layout.toolbar.right', // push attribute to array (default)
//                'edit_page:set'  => 'layout.toolbar.right', // set attribute
//                'edit_page'      => false, // disable button
            ],
            'links'   => [
                'edit_page' => [
                    'component'  => 'c-button',
                    'borderless' => true,
                    'target'     => '_black',
                    'type'       => 'toolbar',
                    /** git.connection_config is a get modifier in Document @see \Codex\Git\GitAddonServiceProvider */
                    'icon'       => '%git.connection_config.driver%',
                    'children'   => 'Edit Page',
                    /** git_links.document_url is a get modifier in Document @see \Codex\Git\GitAddonServiceProvider */
                    'href'       => '%git_links.document_url%',
                ],
            ],
        ],
    ],
];
