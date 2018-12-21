<?php

namespace App\Attributes\Builder;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeParentInterface;
use Symfony\Component\Config\Definition\NodeInterface;

/**
 * This is the class ArrayNodeDefinition.
 *
 * @package App\Attributes\Builder
 * @author  Robin Radic
 * @method  NodeParentInterface|NodeBuilder|NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition|null end()
 */
class ArrayNodeDefinition extends \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition
{
    use WithApiTypes {
        getDefaultApiType as _getDefaultApiType;
    }

    protected function getNodeBuilder()
    {
        if (null === $this->nodeBuilder) {
            $this->nodeBuilder = new NodeBuilder();
        }

        return $this->nodeBuilder->setParent($this);
    }

    public function getDefaultApiType()
    {
        $parts = [];
//        if ($this->parent instanceof NodeInterface) {
//            $parts[] = $this->parent->getName();
//        } elseif ($this->parent instanceof NodeDefinition) {
//            $parts[] = $this->parent->getDefaultApiType();
//        }

        $parts[] = $this->name;
        return studly_case(implode('_', $parts));
    }
}
