<?php

namespace Codex\Blog\Categories\Commands;

use Codex\Blog\Contracts\Blog;
use Codex\Codex;
use Codex\Hooks;
use Illuminate\Filesystem\Filesystem;

class FindCategories
{
    /** @var string */
    protected $blogDir;

    /** @var \Codex\Blog\Contracts\Blog */
    protected $blog;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    public function __construct(Blog $blog, string $blogDir = null)
    {
        $this->blog    = $blog;
        $this->blogDir = $blogDir ?? $blog->attr('paths.blog', resource_path('blog'));
    }

    public function handle(Filesystem $fs, Blog $blog)
    {
        $this->fs = $fs;
        foreach ($fs->directories($this->blogDir) as $directory) {
            if ($configFilePath = $this->getConfigFileFrom($directory)) {
                $paths[ $directory ] = $configFilePath;
            }
        }

        $paths = Hooks::waterfall('blog.categories.found', $paths, [ $this ]);
        return $paths;
    }

    protected function getConfigFileFrom($directory)
    {
        foreach ($this->getAllowedNames() as $name) {
            $path = $directory . '/' . $name;
            if ($this->fs->exists($path)) {
                return $path;
            }
        }
        return false;
    }

    protected function getAllowedNames()
    {
        return $this->blog->attr('allowed_category_config_files', [ 'config.yml' ]);
    }
}
