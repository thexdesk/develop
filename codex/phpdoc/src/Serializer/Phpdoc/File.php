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

namespace Codex\Phpdoc\Serializer\Phpdoc;

use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Annotations\Attr;
use Codex\Phpdoc\Serializer\Concerns\DeserializeFromFile;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Concerns\SerializeToFile;
use Codex\Phpdoc\Serializer\Concerns\WithResponse;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\DocblockProperty;
use Codex\Phpdoc\Serializer\Phpdoc\Types\FileEntityType;
use Illuminate\Contracts\Support\Responsable;
use JMS\Serializer\Annotation as Serializer;

class File implements SelfSerializable, Responsable
{
    use SerializesSelf,
        DocblockProperty,
        SerializeToFile,
        DeserializeFromFile,
        WithResponse;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\Accessor(getter="getType")
     * @Serializer\SerializedName("type")
     * @Attr()
     */
    private $type;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $path;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Serializer\SerializedName("generated-path")
     * @Attr()
     */
    private $generated_path;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $hash;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $package;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\NamespaceAlias[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\NamespaceAlias>")
     * @Serializer\XmlList(inline=true, entry="namespace-alias")
     * @Serializer\SerializedName("uses")
     * @Attr(new=true, array=true)
     */
    private $uses;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile>")
     * @Serializer\Accessor(setter="setClasses")
     */
    private $classes;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile
     * @Serializer\Type("Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile")
     * @Attr(new=true)
     */
    private $class;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile>")
     * @Serializer\Accessor(setter="setInterfaces")
     */
    private $interfaces;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile
     * @Serializer\Type("Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile")
     * @Attr(new=true)
     */
    private $interface;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile>")
     * @Serializer\Accessor(setter="setTraits")
     */
    private $traits;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile
     * @Serializer\Type("Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile")
     * @Attr(new=true)
     */
    private $trait;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Accessor(getter="getSource")
     * @Attr()
     */
    private $source;


    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock
     */
    public function getDocblock(): \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock
    {
        return $this->docblock;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock $docblock
     *
     * @return File
     */
    public function setDocblock(\Codex\Phpdoc\Serializer\Phpdoc\File\Docblock $docblock): self
    {
        $this->docblock = $docblock;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\NamespaceAlias[]
     */
    public function getUses(): array
    {
        return $this->uses;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\NamespaceAlias[] $uses
     *
     * @return File
     */
    public function setUses(array $uses): self
    {
        $this->uses = $uses;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile[] $classes
     *
     * @return File
     */
    public function setClasses(array $classes): self
    {
        if ( ! empty($classes)) {
            $this->class = $classes[ 0 ];
        }
        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile[] $interfaces
     *
     * @return File
     */
    public function setInterfaces(array $interfaces): self
    {
        if ( ! empty($interfaces)) {
            $this->interface = $interfaces[ 0 ];
        }

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile
     */
    public function getTrait()
    {
        return $this->trait;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile[] $traits
     *
     * @return File
     */
    public function setTraits(array $traits): self
    {
        if ( ! empty($traits)) {
            $this->trait = $traits[ 0 ];
        }

        return $this;
    }

    /**
     * getEntityType method.
     *
     * @return \Codex\Phpdoc\Serializer\Phpdoc\Types\FileEntityType
     */
    public function getEntityType(): FileEntityType
    {
        if ($this->isClass()) {
            return FileEntityType::CLASSES();
        }
        if ($this->isInterface()) {
            return FileEntityType::INTERFACES();
        }
        if ($this->isTrait()) {
            return FileEntityType::TRAITS();
        }

        return FileEntityType::GENERICS();
    }

    public function getEntity()
    {
        if ($this->isClass()) {
            return $this->getClass();
        }
        if ($this->isInterface()) {
            return $this->getInterface();
        }
        if ($this->isTrait()) {
            return $this->getTrait();
        }
    }

    public function getType()
    {
        return $this->getEntityType()->getValue();
    }

    /**
     * isClass method.
     *
     * @return bool
     */
    public function isClass()
    {
        return null !== $this->class;
    }

    /**
     * isInterface method.
     *
     * @return bool
     */
    public function isInterface()
    {
        return null !== $this->interface;
    }

    /**
     * isTrait method.
     *
     * @return bool
     */
    public function isTrait()
    {
        return null !== $this->trait;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return File
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeneratedPath(): string
    {
        return $this->generated_path;
    }

    /**
     * @param string $generated_path
     *
     * @return File
     */
    public function setGeneratedPath(string $generated_path): self
    {
        $this->generated_path = $generated_path;

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
     * @return File
     */
    public function setHash(string $hash): self
    {
        $this->hash = $hash;

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
     * @return File
     */
    public function setPackage(string $package): self
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        try {
            return gzuncompress(base64_decode($this->source));
        }
        catch (\Exception $ex) {
            return $this->source;
        }
    }

    /**
     * @param string $source
     *
     * @return File
     */
    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
