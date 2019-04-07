<?php /** @noinspection ALL */

namespace App\Codex\Console;

use Codex\Support\DotArrayWrapper;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ComposerJsonCommand extends Command
{
    protected $signature = 'dev:composer:json';

    /** @var array */
    protected $paths;

    /** @var string */
    protected $packagesPath;

    /** @var array */
    protected $names;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    /** @var \Illuminate\Contracts\View\Factory */
    protected $view;

    /** @var string */
    protected $stubFilePath;

    protected $backupPath;

    public function handle()
    {
        $fs                 = $this->fs = new Filesystem();
        $this->stubFilePath = resource_path('stubs/composer.stub.json');
        $this->packagesPath = base_path('codex');
        $this->paths        = $fs->directories($this->packagesPath);
        $this->names        = array_map('path_get_directory_name', $this->paths);
        $this->backupPath   = storage_path('composer-json-backup/' . time());

        if ( ! $fs->exists($this->backupPath)) {
            $fs->makeDirectory($this->backupPath, 0755, true);
        }

        collect($this->paths)
            ->map(function ($dirPath) {
                $name     = path_get_directory_name($dirPath);
                $filePath = path_join($dirPath, 'composer.json');
                $json     = file_get_contents($filePath);
                $composer = json5_decode($json, true);
                return DotArrayWrapper::make(compact('name', 'dirPath', 'filePath', 'json', 'composer'));
            })->filter(function (DotArrayWrapper $package) {
                return $package->get('name') !== 'test-plugin' && $package->get('name') !== 'composer-plugin';
            })->each(function (DotArrayWrapper $package) {
                $vars   = $this->getVarsFor($package->get('name'));
                $target = DotArrayWrapper::make($package->get('composer'));
                $stub   = DotArrayWrapper::make(json5_decode(file_get_contents($this->stubFilePath), true));

                $target[ 'suggest' ]            = array_except($stub[ 'suggest' ], $target[ 'name' ]);
                $target[ 'keywords' ]           = array_unique(array_merge(
                    $k1 = $stub->get('keywords', []),
                    $k2 = $target->get('keywords', []),
                    $k3 = $vars->get('keywords', [])
                ));
                $target[ 'homepage' ]           = $stub[ 'homepage' ];
                $target[ 'authors' ]            = $stub[ 'authors' ];
                $target[ 'license' ]            = $stub[ 'license' ];
                $target[ 'support' ]            = $stub[ 'support' ];
                $target[ 'support.source' ]     .= $target[ 'name' ];
                $target[ 'extra.branch-alias' ] = $stub[ 'extra.branch-alias' ];


                $target = $this->fixOrder($target);
                $target = $target->toArray();
                $target['keywords'] = array_values($target['keywords']);
                $json   = json_encode($target, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 4);

                $this->fs->move($package[ 'filePath' ], path_join($this->backupPath, $package[ 'name' ] . '.composer.json'));
                $this->fs->put($package[ 'filePath' ], $json);
//                $this->line($json);
//                if(!$this->confirm('next?', true)){
//                    exit();
//                }
                $this->info("[{$package['name']}] composer.json updated");
            });
    }

    protected function fixOrder(DotArrayWrapper $target)
    {
        $new    = DotArrayWrapper::make();
        $rating = [
            'name',
            'type',
            'description',
            'keywords',
            'license',
            'homepage',
            'authors',
            'support',
            'suggest',
            'require',
            'require-dev',
            'autoload',
            'autoload-dev',
            'extra',
            'config',
        ];
        foreach ($rating as $key) {
            if ($target->has($key)) {
                $new->set($key, $target->get($key));
            }
        }

        foreach (array_except($target->toArray(), $new->keys()) as $key => $value) {
            $new->set($key, $value);
        }
        return $new;
    }

    protected function getVarsFor($name)
    {
        $vars = [
            'algolia-search' => [
                'keywords' => [ 'search', 'algolia' ],
            ],
            'auth'           => [
                'keywords' => [ 'auth', 'authentication', 'authorisation', 'oauth', 'socialite', 'social', 'security' ],
            ],
            'blog'           => [
                'keywords' => [ 'blog', 'posts', 'post', 'blogging' ],
            ],
            'comments'       => [
                'keywords' => [ 'comments', 'reactions', 'disqus' ],
            ],
            'filesystems'    => [
                'keywords' => [ 'flysystem', 'filesystem', 'disks', 'remote' ],
            ],
            'git'            => [
                'keywords' => [ 'github', 'bitbucket', 'git', 'webhook', 'synchronisation', 'sync', 'automation', 'branches', 'tags' ],
            ],
            'packagist'      => [
                'keywords' => [ 'packagist', 'api', 'package', 'packages' ],
            ],
            'phpdoc'         => [
                'keywords' => [ 'phpdoc', 'api', 'information', 'links', 'macros', 'api documentation', 'apidoc', 'api-doc' ],
            ],
            'sitemap'        => [
                'keywords' => [ 'sitemap', 'xml', 'search-engine', 'google', 'seo' ],
            ],
        ];

        return collect(data_get($vars, $name, []));
    }
}
