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

namespace Codex\Phpdoc\Serializer;

use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Annotations\Attr;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use JMS\Serializer\Annotation as Serializer;

class ManifestFile implements SelfSerializable
{
    use SerializesSelf;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $name;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $type;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $hash;

    /**
     * @param string $name
     *
     * @return ManifestFile
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return ManifestFile
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     *
     * @return ManifestFile
     */
    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }
}
