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
use JMS\Serializer\Annotation as Serializer;

trait NamedSpacedElement
{
    use DocblockProperty,
        LineProperty;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $namespace;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $package;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlElement()
     * @Attr()
     */
    private $name;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlElement()
     * @Serializer\SerializedName("full_name")
     * @Attr()
     */
    private $full_name;

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     *
     * @return NamedSpacedElement
     */
    public function setNamespace(string $namespace): NamedSpacedElement
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackage(): string
    {
        return $this->package;
    }

    /**
     * @param string $package
     *
     * @return NamedSpacedElement
     */
    public function setPackage(string $package): NamedSpacedElement
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return NamedSpacedElement
     */
    public function setName(string $name): NamedSpacedElement
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param string $full_name
     *
     * @return NamedSpacedElement
     */
    public function setFullName(string $full_name): NamedSpacedElement
    {
        $this->full_name = $full_name;

        return $this;
    }
}
