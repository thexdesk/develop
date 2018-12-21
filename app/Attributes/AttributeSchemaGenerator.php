<?php

namespace App\Attributes;

use App\Attributes\Schema\Type;
use Codex\Support\DotArrayWrapper;
use Symfony\Component\Config\Definition\BaseNode;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\PrototypedArrayNode;

class AttributeSchemaGenerator
{
    /** @var AttributeRegistry */
    protected $registry;

    /** @var DotArrayWrapper */
    protected $types;

    /**
     * AttributeSchemaGenerator constructor.
     *
     * @param \App\Attributes\AttributeRegistry $registry
     */
    public function __construct(AttributeRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function generate()
    {
        $this->types = new DotArrayWrapper();

        foreach ($this->registry->getBuilders() as $builder) {
//            data_set($types, $builder->getApiType(), []);
//            $rootType = new Type($builder->getApiType(), true);
//            $types->push($rootType);

//            $this->types->set($builder->getApiType(), [ 'extend' => true, 'fields' => [] ]);
            $this->getNodeFields($builder->getRootNode());
        }


        $generated = $this->types->collect()->map(function ($item, $key) {
            $type = "type {$key} {";
            if(data_get($item, 'extend', false)){
                $type = "extend {$type}";
            }
            foreach(data_get($item,'fields',[]) as $fieldName => $fieldType){
                $type .= "\n\t{$fieldName}: {$fieldType}";
            }
            $type .= "\n}";
            return $type;
        })->implode("\n");

        return $generated;
    }


    protected function getNodeFields(ArrayNodeDefinition $nodeDefinition, NodeDefinition $parent = null)
    {
        $nodeName = $nodeDefinition->getName();
        $apiType = $nodeDefinition->getApiType();
        $extend  = $nodeDefinition->getApiExtend();
        $new     = $nodeDefinition->getApiNew();
        if ($new || $extend) {
            $this->types->set($apiType, [ 'extend' => $extend, 'fields' => [] ]);
        }
        $fields = [];
        foreach ($nodeDefinition->getChildNodeDefinitions() as $childNodeDefinition) {
            $childApiType = $childNodeDefinition->getApiType();
            $extend       = $childNodeDefinition->getApiExtend();
            $new          = $childNodeDefinition->getApiNew();
            $childName    = $childNodeDefinition->getName();
            if(!$childName || $childName === '' || !$childApiType || $childApiType === ''){
                continue;
            }
            $this->types->set("{$apiType}.fields.{$childName}", $childApiType);
            $fields[$childName] = $childApiType;

            if ($childNodeDefinition instanceof ArrayNodeDefinition) {
                $this->getNodeFields($childNodeDefinition,$nodeDefinition);
                continue;
            }
        }
        $a='a';
    }
}
