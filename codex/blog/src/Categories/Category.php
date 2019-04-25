<?php

namespace Codex\Blog\Categories;

use Codex\Blog\Contracts\Blog;
use Codex\Contracts\Models\ParentInterface;
use Codex\Hooks;
use Codex\Models\Concerns\HasChildren;
use Codex\Models\Concerns\HasParent;
use Codex\Models\Model;
use Codex\Concerns;
use Codex\Blog\Contracts\Categories\Category as CategoryContract;

class Category extends Model implements CategoryContract, ParentInterface
{
    use Concerns\HasFiles;
    use Concerns\HasCodex;
    use HasChildren {
        _setChildrenProperty as setChildren;
    }
    use HasParent {
        _setParentAsProperty as setParent;
    }

    const DEFAULTS_PATH = 'codex-blog.categories';

    /** @var \Codex\Blog\Posts\PostCollection */
    protected $children;

    /** @var string */
    protected $configFilePath;

    public function __construct(array $attributes, Blog $blog)
    {
        $this->setParent($blog);
        $registry                  = $this->getCodex()->getRegistry()->resolve('categories');
        $attributes[ 'extension' ] = path_get_extension($attributes[ 'path' ]);
        $attributes                = Hooks::waterfall('blog.category.initialize', $attributes, [ $registry, $this ]);
        $this->initialize($attributes, $registry);
        $this->addGetMutator('inherits', 'getInheritKeys', true, true);
        $this->addGetMutator('changes', 'getChanges', true, true);
        Hooks::run('blog.category.initialized', [ $this ]);
    }


    public function getConfigFilePath(): string
    {
        return $this->configFilePath;
    }

    public function setConfigFilePath($configFilePath)
    {
        $this->configFilePath = $configFilePath;
        return $this;
    }


}
