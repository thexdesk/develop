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
use Codex\Phpdoc\Annotations\AttrApiType;
use Codex\Phpdoc\Annotations\AttrType;
use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Concerns\DeserializeFromFile;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Concerns\SerializeToFile;
use Codex\Phpdoc\Serializer\Concerns\WithResponse;
use Codex\Phpdoc\Serializer\Manifest;
use Codex\Phpdoc\Serializer\Phpdoc\Types\FileEntityType;
use Illuminate\Contracts\Support\Responsable;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class Project.
 *
 * @author  Robin Radic
 *
 * @Serializer\XmlRoot("project")
 * @Attr
 * @AttrType("dictionary")
 * @AttrApiType("PhpdocStructure", new=true)
 *
 */
class PhpdocStructure implements SelfSerializable, Responsable
{
    use SerializesSelf,
        DeserializeFromFile,
        SerializeToFile,
        WithResponse;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     * @AttrType("string")
     */
    private $title;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     * @AttrType("string")
     */
    private $version;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File>")
     * @Serializer\XmlList(inline=true, entry="file")
     * @Serializer\SerializedName("file")
     */
    private $files;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\Package[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\Package>")
     * @Serializer\XmlList(inline=true, entry="package")
     * @Serializer\SerializedName("package")
     */
    private $packages;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\Package[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\Package>")
     * @Serializer\XmlList(inline=true, entry="namespace")
     * @Serializer\SerializedName("namespace")
     */
    private $namespaces;

    /**
     * @var Manifest
     * @Serializer\Exclude()
     */
    protected $manifest;

    public function getManifest(): Manifest
    {
        if (null === $this->manifest) {
            $this->manifest = new Manifest();
            $this->manifest
                ->setTitle($this->title)
                ->setVersion($this->version)
                ->setNamespaces($this->namespaces)
                ->setPackages($this->packages);

            foreach ($this->getFiles() as $file) {
                if ($file->getEntityType()->equals(FileEntityType::GENERICS())) {
                    continue;
                }
                $entity = $file->getEntity();
                $key    = $entity->getFullName();

                $this->manifest->setFile($key, [
                    'hash' => $file->getHash(),
                    'type' => $file->getType(),
                    'name' => $entity->getName(),
                ]);
            }
        }

        return $this->manifest;
    }

    public function setManifest(Manifest $manifest)
    {
        $this->manifest = $manifest;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return PhpdocStructure
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return PhpdocStructure
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File[] $files
     *
     * @return PhpdocStructure
     */
    public function setFiles(array $files): self
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\Package[]
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\Package[] $packages
     *
     * @return PhpdocStructure
     */
    public function setPackages(array $packages): self
    {
        $this->packages = $packages;

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\Package[]
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\Package[] $namespaces
     *
     * @return PhpdocStructure
     */
    public function setNamespaces(array $namespaces): self
    {
        $this->namespaces = $namespaces;

        return $this;
    }
}
