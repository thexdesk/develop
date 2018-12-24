<?php

namespace Codex\Phpdoc\Serializer;

use Doctrine\Common\Annotations\Reader;

class AttributeAnnotationReader
{
    /** @var \Doctrine\Common\Annotations\Reader */
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function handleClassAnnotations($class)
    {
        if(is_object($class)){
            $class = get_class($class);
        }
        $reflectionClass = new \ReflectionClass($class);
        foreach ($this->reader->getClassAnnotations($reflectionClass) as $i => $annotation) {

            $a='a';
        };
    }
}
