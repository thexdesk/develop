<?php

namespace Codex\Blog\Categories\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ResolvedCategory
{
    use Dispatchable;

    /** @var \Codex\Blog\Contracts\Categories\Category */
    protected $category;
}
