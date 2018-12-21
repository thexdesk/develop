<?php

namespace App\Attributes\Builder;

/**
 * This is the class EnumNodeDefinition.
 *
 * @package App\Attributes\Builder
 * @author  Robin Radic
 * @method  \Symfony\Component\Config\Definition\Builder\NodeParentInterface|NodeBuilder|\Symfony\Component\Config\Definition\Builder\NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition|null end()
 */
class EnumNodeDefinition extends \Symfony\Component\Config\Definition\Builder\EnumNodeDefinition
{
    use WithApiTypes;
}
