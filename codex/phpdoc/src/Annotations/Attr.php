<?php

namespace Codex\Phpdoc\Annotations;

use Codex\Attributes\AttributeDefinition;
use Codex\Attributes\AttributeDefinitionType;
use Doctrine\Common\Annotations\Annotation\Target;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Object_;
use ReflectionClass;
use ReflectionProperty;
use Reflector;

/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
class Attr
{
    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var string */
    private $apiType;

    /** @var bool */
    private $extend = false;

    /** @var bool */
    private $array = false;

    /** @var bool */
    private $new = false;

    /** @var bool */
    private $nonNull = false;

    /** @var bool */
    private $arrayNonNull = false;

    /**
     * Attr constructor.
     */
    public function __construct(array $values)
    {
        if ( ! isset($values[ 'name' ]) && isset($values[ 'value' ])) {
            $this->name = $values[ 'value' ];
        }

        foreach (array_except($values, 'value') as $key => $value) {
            $this->$key = $value;
        }
    }

    protected function getApiTypeOpts()
    {
        $opts = [];
        $keys = [ 'extend', 'array', 'new', 'nonNull', 'arrayNonNull' ];
        foreach ($keys as $key) {
            if ($this->$key === true) {
                $opts[] = $key;
            }
        }
        return $opts;
    }

    /** @var DocBlock|false */
    protected $docblock = false;

    /** @return DocBlock|false */
    protected function resolveDocblock(Reflector $reflector)
    {
        if ($reflector instanceof ReflectionClass || $reflector instanceof ReflectionProperty) {
            $docblock = $reflector->getDocComment();
            if ($docblock !== false) {
                $docblock = DocBlockFactory::createInstance()->create($docblock);
            }
            $this->docblock = $docblock;
        }
        return $this->docblock;
    }

    /** @var ReflectionClass */
    protected $class;

    public function setTargetClass(ReflectionClass $class)
    {
        $this->class = $class;
        $docblock    = $this->resolveDocblock($class);

        if ($this->apiType === null) {
            $this->apiType = ltrim(str_replace_first($class->getNamespaceName(), '', $class->getName()), '\\');
        }
    }

    /** @var ReflectionProperty */
    protected $property;

    public function setTargetProperty(ReflectionProperty $property)
    {
        $this->property = $property;
        $docblock       = $this->resolveDocblock($property);

        if ($this->name === null) {
            $this->name = $property->getName();
        }

        if ($this->type === null && $docblock !== false && $docblock->hasTag('var')) {
            /** @var \phpDocumentor\Reflection\DocBlock\Tags\Var_ $tag */
            $tag = $docblock->getTagsByName('var')[ 0 ];
            /** @var \phpDocumentor\Reflection\Type $type */
            $type = $tag->getType();
            if ($type !== null) {
                $this->type = (string)$type;
            }
        }

        if ($this->new || $this->extend) {
            /** @var \phpDocumentor\Reflection\DocBlock\Tags\Var_ $tag */
            $tag  = $docblock->getTagsByName('var')[ 0 ];
            $type = $tag->getType();
            if ($type instanceof Array_) {
                $type = $type->getValueType();
            }
            if ($type instanceof Object_) {
                if ($this->apiType === null) {
                    $this->apiType = ($type->getFqsen() ? $type->getFqsen()->getName() : null);
                    $this->type    = 'array.arrayPrototype';
                }
                $type = (string)$type->getFqsen();
            }
            $this->childType = $type;
        }


        if($this->type === 'int'){
            $this->type = 'integer';
        }
        if($this->type === 'bool'){
            $this->type = 'boolean';
        }

        if ($this->apiType === null && AttributeDefinitionType::isValid($this->type)) {
            $this->apiType = with(new AttributeDefinitionType($this->type))->toApiType();
        }

        if ($this->new && $this->apiType !== null) {
            $this->apiType = 'Phpdoc' . $this->apiType;
        }
    }


    protected $childType;

    public function hasChildType()
    {
        return isset($this->childType);
    }

    public function getChildType()
    {
        return $this->childType;
    }

    /** @var AttributeDefinition */
    protected $definition;

    public function getAttributeDefinition()
    {
        if ( ! isset($this->definition)) {
            $this->definition = new AttributeDefinition($this->name, $this->type);
            $this->definition->setApiType($this->apiType, $this->getApiTypeOpts());
        }
        return $this->definition;
    }

}
