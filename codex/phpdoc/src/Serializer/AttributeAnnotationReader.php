<?php

namespace Codex\Phpdoc\Serializer;

use Codex\Attributes\AttributeDefinition;
use Codex\Phpdoc\Serializer\Annotations\Attr;
use Doctrine\Common\Annotations\Reader;

class AttributeAnnotationReader
{
    /** @var \Doctrine\Common\Annotations\Reader */
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function handleClassAnnotations($class, AttributeDefinition $parentDefinition = null)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        /** @var \Codex\Attributes\AttributeDefinition $classDefinition */

        $reflectionClass = new \ReflectionClass($class);
        foreach ($this->reader->getClassAnnotations($reflectionClass) as $c => $classAnnotation) {
            if ($classAnnotation instanceof Attr) {
                $classAnnotation->setTargetClass($reflectionClass);
                $parentDefinition = $classAnnotation->getAttributeDefinition();
                break;
            }
        }
        if ($parentDefinition === null) {
            return null;
        }
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            foreach ($this->reader->getPropertyAnnotations($reflectionProperty) as $p => $propertyAnnotation) {
                if ($propertyAnnotation instanceof Attr) {
                    $propertyAnnotation->setTargetProperty($reflectionProperty);
                    $propertyDefinition = $propertyAnnotation->getAttributeDefinition();
                    $parentDefinition->child($propertyDefinition);
                    if ($propertyAnnotation->hasChildType()) {
                        $childType = $propertyAnnotation->getChildType();
                        if (class_exists($childType)) {
                            $childDefinition = $this->handleClassAnnotations($childType, $propertyDefinition);
//                            $propertyDefinition->addChild($childDefinition);
                        }
                    }
                }
            }
        }
        return $parentDefinition;
    }
}
