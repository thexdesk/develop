<?php


namespace App\Attr\Config;


class NodeBuilder extends \Symfony\Component\Config\Definition\Builder\NodeBuilder
{
    public function __construct()
    {
        parent::__construct();
        $this->nodeMapping = [
            'variable' => __NAMESPACE__.'\\VariableNodeDefinition',
            'scalar' => __NAMESPACE__.'\\ScalarNodeDefinition',
            'boolean' => __NAMESPACE__.'\\BooleanNodeDefinition',
            'integer' => __NAMESPACE__.'\\IntegerNodeDefinition',
            'float' => __NAMESPACE__.'\\FloatNodeDefinition',
            'array' => __NAMESPACE__.'\\ArrayNodeDefinition',
            'enum' => __NAMESPACE__.'\\EnumNodeDefinition',
        ];
    }

}
