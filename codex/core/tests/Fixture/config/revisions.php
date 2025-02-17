<?php


$createRevisionConfig = function ($key)
{
    return [
        'key'      => $key,
        'elements' =>
            [
                'blocker' => '<q-chip icon="fa-ban" color="red-10" small square class="task-chip">BLOCKER<q-tooltip class="phpdoc-tooltip">Task Priority: <cc red-10>BLOCKER</cc></q-tooltip></q-chip>',
                'high'    => '<q-chip icon="fa-angle-double-up" color="red-8" small square class="task-chip">HIGH<q-tooltip class="phpdoc-tooltip">Task Priority: <cc red-8>HIGH</cc></q-tooltip></q-chip>',
                'medium'  => '<q-chip icon="fa-ban" color="orange-9" small square class="task-chip">MEDIUM<q-tooltip class="phpdoc-tooltip">Task Priority: <cc orange-9>MEDIUM</cc></q-tooltip></q-chip>',
                'low'     => '<q-chip icon="fa-angle-double-down" color="green-10" small square class="task-chip">LOW<q-tooltip class="phpdoc-tooltip">Task Priority: <cc green-10>LOW</cc></q-tooltip></q-chip>',
                'beta1'   => '<q-chip icon="fa-code-fork" color="light-blue-7" small square class="task-chip">beta.1<q-tooltip class="phpdoc-tooltip">Target Release Version: <cc light-blue-7>2.0.0-beta.1</cc></q-tooltip></q-chip>',
                'beta2'   => '<q-chip icon="fa-code-fork" color="light-blue-4" small square class="task-chip">beta.2<q-tooltip class="phpdoc-tooltip">Target Release Version: <cc light-blue-4>2.0.0-beta.2</cc></q-tooltip></q-chip>',
                'beta3'   => '<q-chip icon="fa-code-fork" color="light-blue-3" small square class="task-chip">beta.3<q-tooltip class="phpdoc-tooltip">Target Release Version: <cc light-blue-3>2.0.0-beta.3</cc></q-tooltip></q-chip>',
            ],
        'css'      =>
            [
                '.q-chip.task-chip'                        =>
                    [
                        'height'       => '16px',
                        'minHeight'    => 'unset',
                        'borderRadius' => 0,
                        'marginRight'  => '3px',
                    ],
                '.q-chip.task-chip .q-icon'                =>
                    [
                        'fontSize'   => '12px',
                        'textShadow' => '1px 1px 1px rgba(12,12,12,0.9)',
                    ],
                '.q-chip.task-chip .q-chip-main'           =>
                    [
                        'fontSize'   => '11px',
                        'fontWeight' => 400,
                        'fontFamily' => '"Hasklig", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;',
                        'textShadow' => '1px 1px 1px rgba(12,12,12,0.9)',
                    ],
                '.q-chip.task-chip .q-chip-side.chip-left' =>
                    [
                        'marginRight' => 0,
                    ],
            ],
        'layout'   =>
            [
                'header' =>
                    [
                        'menu' =>
                            [
                                [
                                    'label'    => 'Test',
                                    'type'     => 'sub-menu',
                                    'children' =>
                                        [
                                            [
                                                'label'    => 'Overview',
                                                'icon'     => 'fa-eye',
                                                'document' => 'index',
                                            ],
                                            [
                                                'label'    => 'TODO',
                                                'icon'     => 'fa-eye',
                                                'document' => 'TODO',
                                            ],
                                        ],
                                ],
                            ],
                    ],
                'footer' =>
                    [
                        'menu' =>
                            [
                                [
                                    'label' => 'Github',
                                    'icon'  => 'fa-github',
                                    'href'  => 'https://github.com/codex-project',
                                ],
                                [
                                    'type' => 'divider',
                                ],
                                [
                                    'label' => 'Packagist',
                                    'icon'  => 'fa-download',
                                    'href'  => 'https://packagist.org/packages/codex',
                                ],
                            ],
                    ],
                'left'   =>
                    [
                        'menu' =>
                            [
                                [
                                    'label'    => 'Overview',
                                    'icon'     => 'fa-eye',
                                    'document' => 'index',
                                ],
                                [
                                    'label'    => 'TODO',
                                    'icon'     => 'fa-eye',
                                    'document' => 'TODO',
                                ],
                                [
                                    'label'    => 'Processors',
                                    'icon'     => 'fa-eye',
                                    'children' =>
                                        [
                                            [
                                                'label'    => 'Links',
                                                'document' => 'links',
                                            ],
                                            [
                                                'label'    => 'Macros',
                                                'document' => 'macros',
                                            ],
                                        ],
                                ],
                                [
                                    'label'    => 'Test Pages',
                                    'icon'     => 'fa-eye',
                                    'children' =>
                                        [
                                            [
                                                'label'    => 'Dev Page',
                                                'document' => 'dev-page',
                                            ],
                                            [
                                                'label'    => 'Document Configuration',
                                                'document' => 'document',
                                            ],
                                            [
                                                'label'    => 'Global Configuration',
                                                'document' => 'global',
                                            ],
                                        ],
                                ],
                                [
                                    'label'    => 'Getting Started',
                                    'icon'     => 'fa-rocket',
                                    'children' =>
                                        [
                                            [
                                                'label'    => 'Installation',
                                                'document' => 'getting-started/installation',
                                            ],
                                            [
                                                'label'    => 'Configuration',
                                                'document' => 'getting-started/configuration',
                                            ],
                                            [
                                                'label'    => 'Creating a project',
                                                'document' => 'getting-started/creating-a-project',
                                            ],
                                        ],
                                ],
                                [
                                    'label'    => 'Menu Test',
                                    'icon'     => 'fa-rocket',
                                    'children' =>
                                        [
                                            [
                                                'label'    => 'Menu Level 1 Item 1',
                                                'icon'     => 'fa-rocket',
                                                'children' =>
                                                    [
                                                        [
                                                            'label'    => 'Menu Level 2 Item 1',
                                                            'document' => 'getting-started/installation',
                                                        ],
                                                        [
                                                            'label'    => 'Menu Level 2 Item 2',
                                                            'document' => 'getting-started/configuration',
                                                        ],
                                                        [
                                                            'label'    => 'Menu Level 2 Item 3',
                                                            'document' => 'getting-started/creating-a-project',
                                                        ],
                                                        [
                                                            'label'    => 'Menu Level 2 Item 4',
                                                            'icon'     => 'fa-rocket',
                                                            'children' =>
                                                                [
                                                                    [
                                                                        'label'    => 'Menu Level 3 Item 1',
                                                                        'icon'     => 'fa-rocket',
                                                                        'document' => 'getting-started/installation',
                                                                    ],
                                                                    [
                                                                        'label'    => 'Menu Level 3 Item 2',
                                                                        'icon'     => 'fa-rocket',
                                                                        'document' => 'getting-started/configuration',
                                                                    ],
                                                                    [
                                                                        'label'    => 'Menu Level 3 Item 3',
                                                                        'icon'     => 'fa-rocket',
                                                                        'document' => 'getting-started/creating-a-project',
                                                                    ],
                                                                    [
                                                                        'label'    => 'Menu Level 3 Item 4',
                                                                        'icon'     => 'fa-rocket',
                                                                        'children' =>
                                                                            [
                                                                                [
                                                                                    'label'    => 'Menu Level 4 Item 1',
                                                                                    'document' => 'getting-started/installation',
                                                                                ],
                                                                                [
                                                                                    'label'    => 'Menu Level 4 Item 2',
                                                                                    'document' => 'getting-started/configuration',
                                                                                ],
                                                                                [
                                                                                    'label'    => 'Menu Level 4 Item 3',
                                                                                    'document' => 'getting-started/creating-a-project',
                                                                                ],
                                                                            ],
                                                                    ],
                                                                ],
                                                        ],
                                                    ],
                                            ],
                                            [
                                                'label'    => 'Menu Level 1 Item 2',
                                                'icon'     => 'fa-rocket',
                                                'children' =>
                                                    [
                                                        [
                                                            'label'    => 'Menu Level 2 Item 1',
                                                            'icon'     => 'fa-rocket',
                                                            'children' =>
                                                                [
                                                                    [
                                                                        'label'    => 'Installation',
                                                                        'document' => 'getting-started/installation',
                                                                    ],
                                                                    [
                                                                        'label'    => 'Configuration',
                                                                        'document' => 'getting-started/configuration',
                                                                    ],
                                                                    [
                                                                        'label'    => 'Creating a project',
                                                                        'document' => 'getting-started/creating-a-project',
                                                                    ],
                                                                ],
                                                        ],
                                                    ],
                                            ],
                                            [
                                                'label'    => 'Installation',
                                                'document' => 'getting-started/installation',
                                            ],
                                            [
                                                'label'    => 'Configuration',
                                                'document' => 'getting-started/configuration',
                                            ],
                                            [
                                                'label'    => 'Creating a project',
                                                'document' => 'getting-started/creating-a-project',
                                            ],
                                        ],
                                ],
                            ],
                    ],
            ],
    ];
};

return [
    $createRevisionConfig('master'),
    $createRevisionConfig('develop'),
    $createRevisionConfig('1.0.0'),
    $createRevisionConfig('1.4.0'),
];
