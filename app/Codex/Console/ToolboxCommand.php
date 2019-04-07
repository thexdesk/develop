<?php

namespace App\Codex\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ToolboxCommand extends Command
{
    protected $signature = 'ide:toolbox';

    public function handle(Filesystem $fs)
    {
        $path = base_path('php-toolbox/ide-toolbox.metadata.json');
        if ($fs->exists($path)) {
            $fs->delete($path);
        }

        $keys = array_keys(array_dot(config()->all()));
        $keys = array_map(function ($key) {
            $segments = explode('.', $key);
            if (last($segments) === '0') {
                array_pop($segments);
                return implode('.', $segments);
            }
            return $key;
        }, $keys);
        $keys = array_filter($keys, function ($key) {
            return is_numeric(last(explode('.', $key))) === false;
        });


        $data = [
            'registrar' => [
                [
                    'language'  => 'php',
                    'provider'  => 'laravel_config',
                    'signature' => [
                        'Illuminate\Config\Repository::get',
                        'Illuminate\Contracts\Config\Repository::get',
                        'Config::get',
                        'config'
                    ],
                ],
            ],
            'providers' => [
                [
                    'name'           => 'laravel_config',
                    'lookup_strings' => array_values($keys),
                ],
            ],
        ];

        $content = json_encode($data, JSON_PRETTY_PRINT);
        $fs->put($path, $content);
    }
}
