<?php


namespace App\Attr;


use App\Attr\Config\ArrayNodeDefinition;
use App\Attr\Config\NodeBuilder;
use App\Attr\Config\TreeBuilder;
use App\Attr\Type as T;

class BuildDefinitionConfig
{
    /** @var \App\Attr\DefinitionGroup */
    protected $group;

    /**
     * @var \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    protected $builder;

    public function __construct(\App\Attr\DefinitionGroup $group)
    {
        $this->group   = $group;
        $this->builder = new TreeBuilder($group->name);
    }

    public function handle()
    {
        $group           = $this->group;
        $builderRootNode = $this->builder->getRootNode();
        $builderRootNode->ignoreExtraKeys(true);
        $builderRootNode->addDefaultsIfNotSet();

        $this->traverseChildren($group->children, $builderRootNode);

        return $this->builder->buildTree();
    }

    /**
     * @param \Illuminate\Support\Collection|Definition[]                      $children
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    protected function traverseChildren($children, ArrayNodeDefinition $node)
    {
        foreach ($children as $definition) {
            $this->handleChild($definition, $node);
        }
    }

    /**
     * @param \App\Attr\Definition                                                                                                         $definition
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition $parentNode
     */
    public function handleChild(Definition $definition, ArrayNodeDefinition $parentNode)
    {
        $type        = $definition->type;
        $childType   = $type->getChildType();
        $hasChildren = $definition->hasChildren();
        $children    = $definition->children;

        if ( ! $type->isChildType()) {
            $node = $parentNode->children()->node(
                $definition->name,
                T::getConfigNodeTypeName($definition->type)
            );
        } elseif ($type->is(T::RECURSE)) {
            $parentNode->addDefaultsIfNotSet();
            $parentNode->ignoreExtraKeys(true);
            $node = $parentNode->children()->arrayNode($definition->name);
//            $node = $node->arrayPrototype();
        } elseif ($type->is(T::RECURSIVE)) {
            $target = $parentNode; //->children()->arrayNode($definition->name);
//            $target->addDefaultsIfNotSet();
//            $target->ignoreExtraKeys();

            /** @var Definition $recurseChild */
            $recurseChild = $children->filter(function (Definition $definition) {
                return $definition->type->is(T::RECURSE);
            })->first();

            $node = $this->getArrayRecursiveDefinition($definition->name, $recurseChild->name, function (NodeBuilder $builder, ArrayNodeDefinition $node) use ($children) {
                $children->filter(function (Definition $definition) {
                    return false === $definition->type->is(T::RECURSE);
                })->each(function (Definition $definition) use ($builder, $node) {
                    $this->handleChild($definition, $node);
                });
            });

            $target->append($node);
            return;
        } elseif ($type->is(T::ARRAY)) {
            if ($childType->is(T::MAP)) {
                $node = $parentNode->children()->arrayNode($definition->name);
                $node->ignoreExtraKeys();
                $node = $node->arrayPrototype();
                $node->ignoreExtraKeys();
            } else {

                $node = $parentNode->children()->arrayNode($definition->name);
                $node->ignoreExtraKeys();
            }
            if ($hasChildren) {

            }
        } elseif ($type->is(T::MAP)) {
            $node = $parentNode->children()->arrayNode($definition->name);
            $node->ignoreExtraKeys();;
            if ( ! $hasChildren) {
                $node = $node->variablePrototype();
            }
        }
        if (isset($definition->default)) {
            if ($node->getNode()) {
                $node->defaultValue($definition->default);
            }
            if (method_exists($node, 'addDefaultsIfNotSet')) {
                $node->addDefaultsIfNotSet();
            }
        }
        if ($definition->required) {
            $node->isRequired();
        }
        if ($definition->children->isNotEmpty()) {
            $parentNode->ignoreExtraKeys(true);
            $this->traverseChildren($definition->children, $node);
        }
    }

    /**
     * @param \Illuminate\Support\Collection|Definition[]                      $children
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    public function buildRecursive(ArrayNodeDefinition $node, $recurseChildName, callable $addFn)
    {
        $child = $node->children();
        $addFn($child, $node);
        $builder  = new TreeBuilder($recurseChildName, 'variable');
        $rootNode = $builder->getRootNode();
        $rootNode->defaultValue([])
            ->validate()
            ->ifTrue(function ($v) {
                return ! is_array($v);
            })
            ->thenInvalid('Element must be array')
            ->always(function (iterable $children) use ($builder, $recurseChildName, $addFn) {
                $config = [];
                foreach ($children as $name => $child) {
                    $node = $builder->root($name);
                    $node->addDefaultsIfNotSet();
                    $this->buildRecursive($node, $recurseChildName, $addFn);
                    $config[ $name ] = $node->getNode(true)->finalize($child);
                }
                return $config;
            });
        $child->append($rootNode);
    }

    protected function getArrayRecursiveDefinition($name, $recurseName, callable $addFn)
    {
        $node = static::node($name);
        $this->buildRecursive($node->arrayPrototype(), $recurseName, $addFn);
        return $node;
    }

    public static function builder($name, $type = 'array')
    {
        return new TreeBuilder($name, $type);
    }

    /**
     * node method
     *
     * @param        $name
     * @param string $type
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition|\Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition
     */
    public static function node($name, $type = 'array')
    {
        return static::builder($name, $type)->getRootNode();
    }


}
