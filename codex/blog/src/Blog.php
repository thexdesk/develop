<?php

namespace Codex\Blog;

use Codex\Blog\Categories\CategoryCollection;
use Codex\Blog\Contracts\Blog as BlogContract;
use Codex\Concerns;
use Codex\Contracts\Models\ChildInterface;
use Codex\Contracts\Models\ParentInterface;
use Codex\Hooks;
use Codex\Models\Concerns\HasChildren;
use Codex\Models\Concerns\HasParent;
use Codex\Models\Model;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;

/**
 * @method CategoryCollection getChildren()
 */
class Blog extends Model implements BlogContract,ParentInterface, ChildInterface
{
    use Concerns\HasCodex;
    use HasChildren {
        _setChildrenProperty as setChildren;
    }
    use HasParent {
        _setParentAsProperty as setParent;
    }

    const DEFAULTS_PATH = 'codex-blog';

    /** @var \Codex\Codex */
    protected $parent;

    /** @var \Codex\Blog\Categories\CategoryCollection */
    protected $children;

    /**
     * Blog constructor.
     *
     * @param \Codex\Codex $parent
     */
    public function __construct(Config $config, CategoryCollection $categories)
    {
        $this->setParent($this->getCodex());
        $this->setChildren($categories->setParent($this));

        $registry   = $this->getCodex()->getRegistry()->resolve('blog');
        $attributes = $config->get('codex-blog', []);
        $attributes = Hooks::waterfall('blog.initialize', $attributes, [ $registry, $this ]);
        $this->initialize($attributes, $registry);
        $this->addGetMutator('inherits', 'getInheritKeys', true, true);
        $this->addGetMutator('changes', 'getChanges', true, true);
        Hooks::run('blog.initialized', [ $this ]);
    }

    public function categories()
    {
        return $this->getCategories()->toRelationship();
    }

    public function getCategories()
    {
        return $this->children->resolve();
    }

    public function getCategory($key)
    {
        return $this->getCategories()->get($key);
    }

    public function hasCategory($key)
    {
        return $this->getCategories()->has($key);
    }

    public function getDefaultCategoryKey()
    {
        return $this->getCategories()->getDefaultKey();
    }
}
