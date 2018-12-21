<?php

namespace App\Attributes\Builder;

class NodeBuilder extends \Symfony\Component\Config\Definition\Builder\NodeBuilder
{
    public function __construct()
    {
        parent::__construct();
        $this->nodeMapping = array(
            'variable' => __NAMESPACE__.'\\VariableNodeDefinition',
            'scalar' => __NAMESPACE__.'\\ScalarNodeDefinition',
            'boolean' => __NAMESPACE__.'\\BooleanNodeDefinition',
            'integer' => __NAMESPACE__.'\\IntegerNodeDefinition',
            'float' => __NAMESPACE__.'\\FloatNodeDefinition',
            'array' => __NAMESPACE__.'\\ArrayNodeDefinition',
            'enum' => __NAMESPACE__.'\\EnumNodeDefinition',
            'string' => __NAMESPACE__.'\\StringNodeDefinition',
        );

    }

    /**
     * stringNode method
     *
     * @param $name
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition|\App\Attributes\Builder\StringNodeDefinition
     */
    public function stringNode($name)
    {
        return $this->node($name, 'string');
    }
}
