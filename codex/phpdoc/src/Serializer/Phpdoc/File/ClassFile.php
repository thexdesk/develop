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

use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Annotations\Attr;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\FileEntityElement;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\NamedSpacedElement;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class ClassFile.
 *
 * @author  Robin Radic
 *
 * @Serializer\XmlRoot("class")
 */
class ClassFile implements SelfSerializable
{
    use SerializesSelf,
        NamedSpacedElement,
        FileEntityElement;

    /**
     * @var string[]
     * @Serializer\Type("LaravelCollection<string>")
     * @Serializer\XmlList(inline=true, entry="implements")
     * @Attr(type="array", array=true)
     */
    private $implements;

    /**
     * @return string[]|\Codex\Phpdoc\Serializer\Handler\LaravelCollection
     */
    public function getImplements()
    {
        return $this->implements;
    }

    /**
     * @param string[] $implements
     *
     * @return ClassFile
     */
    public function setImplements(array $implements): self
    {
        $this->implements = $implements;

        return $this;
    }
}
