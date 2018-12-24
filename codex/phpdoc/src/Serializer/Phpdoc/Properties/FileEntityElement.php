<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc\Serializer\Phpdoc\Properties;

use JMS\Serializer\Annotation as Serializer;

trait FileEntityElement
{
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlElement(cdata=false)
     */
    private $extends;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\Property[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\Property>")
     * @Serializer\XmlList(inline=true, entry="property")
     * @Serializer\SerializedName("property")
     */
    private $properties;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\Method[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\Method>")
     * @Serializer\XmlList(inline=true, entry="method")
     * @Serializer\SerializedName("method")
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
    public function setExtends(string $extends): FileEntityElement
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\Property[] $properties
     *
     * @return FileEntityElement
     */
    public function setProperties(array $properties): FileEntityElement
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\Method[] $methods
     *
     * @return FileEntityElement
     */
    public function setMethods(array $methods): FileEntityElement
    {
        $this->methods = $methods;

        return $this;
    }
}
