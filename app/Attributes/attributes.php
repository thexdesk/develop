<?php

use App\Attributes\AttributeRegistry as Attr;

return function (Attr $registry) {

    function buildMenuDefinition(\Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node)
    {
        $child = $node->addDefaultsIfNotSet()->children();

        $child
            ->scalarNode('id')->defaultValue(function () {
                return md5(str_random());
            })->end()
            ->enumNode('type')->values([ 'link', 'router-link', 'sub-menu', 'side-menu' ])->defaultValue('link')->end()
            ->enumNode('side')->values([ 'left', 'right' ])->end()
            ->enumNode('target')->values([ 'blank', 'self', 'parent', 'top' ])->defaultValue('self')->end()
            ->stringNode('href')->end()
            ->stringNode('path')->end()
            ->booleanNode('expand')->end()
            ->booleanNode('selected')->end()
            ->stringNode('label')->end()
            ->stringNode('sublabel')->end()
            ->stringNode('icon')->end()
            ->stringNode('color')->end()
            ->stringNode('project')->end()
            ->stringNode('revision')->end()
            ->stringNode('document')->end()
            ->booleanNode('projects')->end()
            ->booleanNode('revisions')->end();

        $builder = Attr::builder('children', 'variable');
        $def     = $builder->getRootNode();
        $def->defaultValue([])
            ->validate()
            ->ifTrue(function ($v) {
                return ! is_array($v);
            })
            ->thenInvalid('The element must be an array.')
            ->always(function (iterable $children) use ($builder, $child, $def) {
                $config = [];
                foreach ($children as $name => $child) {
                    $node = $builder->root($name);
                    buildMenuDefinition($node);
                    $config[ $name ] = $node->getNode(true)->finalize($child);
                }
                return $config;
            });

        $child->append($def);
    }

    function getMenuDefinition($name)
    {
        $node = Attr::node($name);
        buildMenuDefinition($node->arrayPrototype());
        return $node;
    }

    function getLayoutPartDefinition($name)
    {
        $node = Attr::node($name);
        $node->addDefaultsIfNotSet()->children()
            ->arrayNode('class')->setApiType('Assoc')->arrayPrototype()->end()->end()
            ->arrayNode('style')->setApiType('Assoc')->arrayPrototype()->end()->end()
            ->stringNode('color')->defaultNull()->end();
        return $node;
    }

    function getLayoutHorizontalSideDefinition($name)
    {
        $node = getLayoutPartDefinition($name);
        $node->children()
            ->booleanNode('show')->defaultTrue()->end()
            ->booleanNode('collapsed')->defaultFalse()->end()
            ->booleanNode('outside')->defaultTrue()->end()
            ->integerNode('width')->defaultValue(200)->end()
            ->integerNode('collapsedWidth')->defaultValue(50)->end();
        $node->append(getMenuDefinition('menu'));
        return $node;
    }

    function getLayoutVerticalSideDefinition($name)
    {
        $node = getLayoutPartDefinition($name);
        $node->children()
            ->booleanNode('show')->defaultTrue()->end()
            ->booleanNode('fixed')->defaultFalse()->end()
            ->integerNode('height')->defaultValue(64)->end();
        $node->append(getMenuDefinition('menu'));
        return $node;
    }

    function getLayoutDefinition($name)
    {
        $node = getLayoutPartDefinition($name);
        $node->children()
            ->booleanNode('show')->defaultTrue()->end()
            ->booleanNode('fixed')->defaultFalse()->end()
            ->integerNode('height')->defaultValue(64)->end();
        $node->append(getMenuDefinition('menu'));
        return $node;
    }

    $registry->codex()->getRootNode()->addDefaultsIfNotSet();
    $registry->codex()->children()
        ->stringNode('display_name')->defaultValue(function () {
            return env('CODEX_DISPLAY_NAME', config('app.name', 'Codex'));
        })->end()
        ->stringNode('description')->defaultValue('')->end()
        ->stringNode('default_project')->end();

    $layout = $registry->codex()->children()
        ->arrayNode('layout')->addDefaultsIfNotSet()
        ->setApiTypeDefinition('Layout', false, true);

    $layout
        ->append(getLayoutPartDefinition('container')->setApiTypeDefinition('LayoutContainer', false, true)->children()->booleanNode('stretch')->defaultTrue()->end()->end())
        ->append(getLayoutVerticalSideDefinition('header')->setApiTypeDefinition('LayoutHeader', false, true))
        ->append(getLayoutHorizontalSideDefinition('left')->setApiTypeDefinition('LayoutLeft', false, true))
        ->append(getLayoutPartDefinition('middle')->setApiTypeDefinition('LayoutMiddle', false, true)->children()->integerNode('padding')->defaultValue(24)->end()->end())
        ->append(getLayoutPartDefinition('content')->setApiTypeDefinition('LayoutContent', false, true))
        ->append(getLayoutHorizontalSideDefinition('right')->setApiTypeDefinition('LayoutRight', false, true))
        ->append(getLayoutVerticalSideDefinition('footer')->setApiTypeDefinition('LayoutFooter', false, true));


    $registry->projects()
        ->addInheritKeys([ 'processors', 'layout' ])
        ->getRootNode()->addDefaultsIfNotSet();

    $registry->projects()->children()
        ->stringNode('display_name')->defaultNull()->end()
        ->stringNode('description')->defaultValue('')->end()
        ->stringNode('default_revision')->end()
        ->stringNode('disk')->defaultNull()->end()
        ->stringNode('view')->defaultValue('codex::document')->end()
        ->arrayNode('cache')->addDefaultsIfNotSet()->children()
        ->enumNode('mode')->values([ true, false, null ])->defaultNull()->end()
        ->integerNode('minutes')->defaultValue(7)->end()
        ->end();

    $registry->revisions()
        ->addMergeKeys([])
        ->addInheritKeys([ 'processors', 'layout', 'view', 'cache' ])
        ->getRootNode()->addDefaultsIfNotSet();
    $registry->revisions()->children()
        ->stringNode('default_document')->end();
};
