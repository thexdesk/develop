<?php

namespace App\Attributes;

use App\Attributes\Builder\TreeBuilder;

class AttributeRegistry
{
    /** @var \Illuminate\Support\Collection|TreeBuilder[] */
    protected $builders;

    /**
     * AttributeRegistry constructor.
     */
    public function __construct()
    {
        $this->builders = collect([
            'codex'     => $this->makeTreeBuilder('codex', 'Codex'),
            'projects'  => $this->makeTreeBuilder('projects', 'Project'),
            'revisions' => $this->makeTreeBuilder('revisions', 'Revision'),
            'documents' => $this->makeTreeBuilder('documents', 'Document'),
        ]);
    }

    protected function makeTreeBuilder(string $name, string $apiType)
    {
        return with(new TreeBuilder($name, 'array'))->setApiTypeDefinition($apiType, true);
    }

    /**
     * getBuilders method
     *
     * @return \App\Attributes\Builder\TreeBuilder[]|\Illuminate\Support\Collection
     */
    public function getBuilders()
    {
        return $this->builders;
    }

    /**
     * getBuilder method
     *
     * @param $name
     *
     * @return TreeBuilder
     */
    public function getBuilder($name)
    {
        return $this->builders->get($name);
    }

    /**
     * getBuilderRootNode method
     *
     * @param $name
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition|\Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition
     */
    public function getBuilderRootNode($name)
    {
        return $this->getBuilder($name)->getRootNode();
    }

    public function codex()
    {
        return $this->getBuilder('codex');
    }

    public function projects()
    {
        return $this->getBuilder('projects');
    }

    public function revisions()
    {
        return $this->getBuilder('revisions');
    }

    public function documents()
    {
        return $this->getBuilder('documents');
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
