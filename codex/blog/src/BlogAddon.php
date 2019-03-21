<?php

namespace Codex\Blog;

use Codex\Addons\Addon;
use Illuminate\Filesystem\Filesystem;

class BlogAddon extends Addon
{
    public function onInstalled()
    {
        $fs        = resolve(Filesystem::class);
        $postsPath = config('codex-blog.paths.posts');
        if ( ! $fs->isDirectory($postsPath)) {
            $fs->makeDirectory($postsPath, 0755, true);
        }
    }
}
