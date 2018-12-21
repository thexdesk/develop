<?php

namespace App\Attributes\Builder;

/**
 * This is the class BooleanNodeDefinition.
 *
 * @package App\Attributes\Builder
 * @author  Robin Radic
 * @method  \Symfony\Component\Config\Definition\Builder\NodeParentInterface|NodeBuilder|\Symfony\Component\Config\Definition\Builder\NodeDefinition|ArrayNodeDefinition|VariableNodeDefinition|null end()
 */
class BooleanNodeDefinition extends \Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition
{
    use WithApiTypes;

    public function getDefaultApiType()
    {
        return 'Boolean';
    }
}
