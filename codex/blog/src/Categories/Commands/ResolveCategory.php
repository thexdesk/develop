<?php

namespace Codex\Blog\Categories\Commands;

use Codex\Blog\Categories\Events\ResolvedCategory;
use Codex\Blog\Contracts\Blog;
use Codex\Blog\Contracts\Categories\Category;
use Codex\Hooks;
use Codex\Mergable\Commands\MergeAttributes;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Yaml\Yaml;

class ResolveCategory
{
    use DispatchesJobs;

    /** @var \Codex\Blog\Contracts\Blog */
    protected $blog;

    /** @var string */
    protected $configFilePath;

    /** @var \Codex\Blog\Contracts\Categories\Category */
    protected $category;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    public function __construct(Blog $blog, string $configFilePath)
    {
        $this->blog           = $blog;
        $this->configFilePath = $configFilePath;
    }

    public function handle(Filesystem $fs)
    {
        $this->fs = $fs;
        $category = $this->makeCategory();
        $this->dispatch(new MergeAttributes($category));
        Hooks::run('blog.categories.resolved', [ $this ]);
        $category->fireEvent('resolved', $category);
        ResolvedCategory::dispatch($category);
        return $category;
    }

    protected function makeCategory()
    {
        $path                = $this->configFilePath;
        $attributes          = $this->getAttributes();
        $attributes[ 'key' ] = basename(dirname($path));
        $attributes[ 'path' ] = $path;
        $blog                = $this->blog;
        $this->category      = app()
            ->make(Category::class, compact('attributes', 'blog'))
            ->setParent($blog)
            ->setConfigFilePath($path);

        return $this->category;
    }

    protected function getAttributes()
    {
        $content = $this->fs->get($this->configFilePath);
//        $isPhp   = ends_with($this->configFilePath, '.php');
//        if ($isPhp) {
//            $localFS     = app(Filesystem::class);
//            $tmpFilePath = storage_path(str_random() . '.php');
//            $localFS->put($tmpFilePath, $content);
//            $attributes = require $tmpFilePath;
//            $localFS->delete($tmpFilePath);
//            return $attributes;
//        }
        $attributes = Yaml::parse($content,Yaml::PARSE_OBJECT);
        $attributes = is_array($attributes) ? $attributes : [];
        return $attributes;
    }
}
