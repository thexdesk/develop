<?php


namespace App\Attr\Config;


use Symfony\Component\Config\Definition\Builder\NodeBuilder as SymfonyNodeBuilder;

class TreeBuilder extends \Symfony\Component\Config\Definition\Builder\TreeBuilder
{
    public function root($name, $type = 'array', SymfonyNodeBuilder $builder = null)
    {
        $builder = $builder ?: new NodeBuilder();
        return parent::root($name, $type, $builder);
    }
}
