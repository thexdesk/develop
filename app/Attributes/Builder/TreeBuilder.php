<?php

namespace App\Attributes\Builder;

use Illuminate\Support\Arr;
use Symfony\Component\Config\Definition\BaseNode;

/**
 * This is the class TreeBuilder.
 *
 * @package App\Attributes\Builder
 * @author  Robin Radic
 * @method \App\Attributes\Builder\ArrayNodeDefinition getRootNode()
 */
class TreeBuilder extends \Symfony\Component\Config\Definition\Builder\TreeBuilder
{
    protected $merges;

    protected $inherits;

    /** @var string */
    protected $apiType;

    public function __construct(string $name = null, string $type = 'array', \Symfony\Component\Config\Definition\Builder\NodeBuilder $builder = null)
    {
        parent::__construct($name, $type, $builder);
        $this->merges   = collect();
        $this->inherits = collect();
    }

    public function root($name, $type = 'array', \Symfony\Component\Config\Definition\Builder\NodeBuilder $builder = null)
    {
        $builder = $builder ?: new NodeBuilder();

        return $this->root = $builder->node($name, $type)->setParent($this);
    }

    public function children()
    {
        return $this->getRootNode()->children();
    }

    public function addMergeKeys($keys)
    {
        foreach (Arr::wrap($keys) as $key) {
            $this->merges->push($key);
        }
        return $this;
    }

    public function addInheritKeys($keys)
    {
        foreach (Arr::wrap($keys) as $key) {
            $this->inherits->push($key);
        }
        return $this;
    }

    public function getMerges()
    {
        return $this->merges;
    }

    public function getInherits()
    {
        return $this->inherits;
    }

    public function setApiType(string $type)
    {
        $this->setApiTypeDefinition($type);
        return $this;
    }

    public function setApiTypeDefinition(string $type, bool $extend = false, bool $new = false)
    {
        $this->getRootNode()->setApiTypeDefinition($type, $extend, $new);
        return $this;
    }


}
