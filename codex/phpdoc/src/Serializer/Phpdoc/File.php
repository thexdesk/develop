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

use Codex\Phpdoc\Annotations\Attr;
use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
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
    private $generatedPath;

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
     * @Serializer\SerializedName("namespace-alias")
     * @Attr(new=true, array=true)
     */
    private $namespaceAlias;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile>")
     * @Serializer\XmlList(inline=true, entry="class", skipWhenEmpty=true)
     * @Attr(new=true, array=true)
     */
    private $class;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile>")
     * @Serializer\XmlList(inline=true, entry="interface", skipWhenEmpty=true)
     * @Attr(new=true, array=true)
     */
    private $interface;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile>")
     * @Serializer\XmlList(inline=true, entry="trait", skipWhenEmpty=true)
     */
    private $trait;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Accessor(getter="getSource")
     */
    private $source;

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

    /**
     * getType method.
     *
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("type")
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->getEntityType()->getValue();
    }

    /**
     * getType method.
     *
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("entity")
     *
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile|\Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile|\Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile
     */
    public function getEntity()
    {
        if ($this->isClass()) {
            return $this->getClass()[ 0 ];
        }
        if ($this->isInterface()) {
            return $this->getInterface()[ 0 ];
        }
        if ($this->isTrait()) {
            return $this->getTrait()[ 0 ];
        }
    }

    /**
     * isClass method.
     *
     * @return bool
     */
    public function isClass()
    {
        return null !== $this->class && 0 !== \count($this->class);
    }

    /**
     * isInterface method.
     *
     * @return bool
     */
    public function isInterface()
    {
        return null !== $this->interface && 0 !== \count($this->interface);
    }

    /**
     * isTrait method.
     *
     * @return bool
     */
    public function isTrait()
    {
        return null !== $this->trait && 0 !== \count($this->trait);
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
        return $this->generatedPath;
    }

    /**
     * @param string $generatedPath
     *
     * @return File
     */
    public function setGeneratedPath(string $generatedPath): self
    {
        $this->generatedPath = $generatedPath;

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
    public function getNamespaceAlias(): array
    {
        return $this->namespaceAlias;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\NamespaceAlias[] $namespaceAlias
     *
     * @return File
     */
    public function setNamespaceAlias(array $namespaceAlias): self
    {
        $this->namespaceAlias = $namespaceAlias;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile[]
     */
    public function getClass(): array
    {
        return $this->class;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\ClassFile[] $class
     *
     * @return File
     */
    public function setClass(array $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile[]
     */
    public function getInterface(): array
    {
        return $this->interface;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\InterfaceFile[] $interface
     *
     * @return File
     */
    public function setInterface(array $interface): self
    {
        $this->interface = $interface;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile[]
     */
    public function getTrait(): array
    {
        return $this->trait;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\TraitFile[] $trait
     *
     * @return File
     */
    public function setTrait(array $trait): self
    {
        $this->trait = $trait;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
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
