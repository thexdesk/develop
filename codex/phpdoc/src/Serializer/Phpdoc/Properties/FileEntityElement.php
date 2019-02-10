<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author    Robin Radic
 * @license   https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc\Serializer\Phpdoc\Properties;

use Codex\Phpdoc\Serializer\Annotations\Attr;
use Codex\Phpdoc\Serializer\Phpdoc\File\Method;
use Codex\Phpdoc\Serializer\Phpdoc\File\Property;
use JMS\Serializer\Annotation as Serializer;

trait FileEntityElement
{
    /**
     * @var string[]
     * @Serializer\Type("array<string>")
     * @Serializer\XmlList(inline=true, entry="extends")
     * @Serializer\Accessor(setter="setExtends")
     * @Attr(type="string", array=true)
     */
    private $extends;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\Property[]
     * @Serializer\Type("LaravelCollection<Codex\Phpdoc\Serializer\Phpdoc\File\Property>")
     * @Serializer\XmlList(inline=true, entry="property")
     * @Serializer\Accessor(setter="setProperties")
     * @Attr(new=true,array=true)
     */
    private $properties;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\Method[]
     * @Serializer\Type("LaravelCollection<Codex\Phpdoc\Serializer\Phpdoc\File\Method>")
     * @Serializer\XmlList(inline=true, entry="method")
     * @Serializer\Accessor(setter="setMethods")
     * @Attr(new=true,array=true)
     */
    private $methods;

    /**
     * @return string
     */
    public function getExtends(): string
    {
        return $this->extends;
    }

    /**
     * @param string $extends
     *
     * @return FileEntityElement
     */
    public function setExtends(array $extends)
    {
        $extends       = array_filter($extends, 'strlen');
        $this->extends = $extends;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Handler\LaravelCollection|\Codex\Phpdoc\Serializer\Phpdoc\File\Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\Property[] $properties
     *
     * @return FileEntityElement
     */
    public function setProperties($properties): self
    {
        $this->properties = $properties->filter(function (Property $property) {
            return false === $property->getDocblock()->hasTag('magic');
        });
        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Handler\LaravelCollection|\Codex\Phpdoc\Serializer\Phpdoc\File\Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\Method[] $methods
     *
     * @return FileEntityElement
     */
    public function setMethods($methods): self
    {
        $this->methods = $methods->filter(function (Method $method) {
            return false === $method->getDocblock()->hasTag('magic');
        });
        return $this;
    }
}
