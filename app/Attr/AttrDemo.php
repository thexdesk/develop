<?php

namespace App\Attr;

use App\Attr\Type as T;

class AttrDemo
{
    public function handle()
    {
        $array = T::ARRAY;

        $size      = "large";
        $var_array = [
            "color" => "blue",
            "size"  => "medium",
            "shape" => "sphere",
        ];
        extract($var_array, EXTR_PREFIX_SAME, "wddx");


        $config   = config('codex', []);
        $registry = new DefinitionRegistry();
        $codex    = $registry->codex;
        $codex->child('changes', T::ARRAY)->default([]);
        $cache = $codex->child('cache', T::ARRAY)->api('CacheConfig', [ 'new' ]);

        $cache->child('enabled', T::BOOL);
        $cache->child('key', T::STRING);
        $cache->child('minutes', T::INT);

        $codex->child('display_name', T::ARRAY, 'Codex')->required();
        $codex->child('description', T::STRING, '');
        $codex->child('default_project', T::STRING)->api('ID')->required();

        foreach ($registry->keys() as $name) {
            $group     = $registry->getGroup($name);
            $processor = new ConfigProcessor();
            $config    = $processor->process($group, $config);
        }

        $def = new DefinitionGroup();

        $def->child('default_attributes', T::ARRAY)
            ->default([])
            ->api('DefaultAttributes', [ 'new' ]);

        $attributes = $def->child('attributes', T::ARRAY);

        $attributes->child('height', T::INT)
            ->default(0);

        $def->child('names', T::ARRAY, '[String]')
            ->default([ 'a', 'b', 'c' ]);

        $def->child('test', T::STRING, '[String]')
            ->default('%default_attributes.label%');


        $processor = new ConfigProcessor();
        $c         = $processor->process($def, [
            'default_attributes' => [
                'label' => 'asdf',
            ],
            'attributes'         => [
                'text'   => '%default_attributes.label%',
                'menu'   => [
                    [
                        'label'    => 'Hello',
                        'type'     => 'submenu',
                        'children' => [
                            [
                                'label'    => 'Hello First',
                                'type'     => 'document',
                                'document' => 'first',
                            ],
                            [
                                'label'    => 'Hello Second',
                                'type'     => 'document',
                                'document' => 'second',
                            ],
                        ],
                    ],
                ],
                'show'   => false,
                'height' => 'ninethousand',
            ],
        ]);


        return $c;
    }
}
