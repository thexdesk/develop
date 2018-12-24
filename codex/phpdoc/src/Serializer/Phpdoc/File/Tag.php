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

namespace Codex\Phpdoc\Serializer\Phpdoc\File;

use Codex\Phpdoc\Annotations\Attr;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class Tag.
 *
 * @author  Robin Radic
 *
 * @Serializer\XmlRoot("tag")
 */
class Tag
{
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $name;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $line;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $description;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $link;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $refers;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $type;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $variable;

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
     * @return Tag
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    /**
     * @param int $line
     *
     * @return Tag
     */
    public function setLine(int $line): self
    {
        $this->line = $line;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Tag
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return Tag
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefers(): string
    {
        return $this->refers;
    }

    /**
     * @param string $refers
     *
     * @return Tag
     */
    public function setRefers(string $refers): self
    {
        $this->refers = $refers;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Tag
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getVariable(): string
    {
        return $this->variable;
    }

    /**
     * @param string $variable
     *
     * @return Tag
     */
    public function setVariable(string $variable): self
    {
        $this->variable = $variable;

        return $this;
    }
}
