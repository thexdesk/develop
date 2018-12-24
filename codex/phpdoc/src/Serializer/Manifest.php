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

use Codex\Contracts\Revisions\Revision;
use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Concerns\DeserializeFromFile;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Concerns\SerializeToFile;
use Codex\Phpdoc\Serializer\Concerns\WithResponse;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Illuminate\Contracts\Support\Responsable;
use JMS\Serializer\Annotation as Serializer;

class Manifest implements SelfSerializable, Responsable
{
    use SerializesSelf,
        DeserializeFromFile,
        SerializeToFile,
        WithResponse;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $title;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $version;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\Package[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\Package>")
     * @Serializer\XmlList(inline=true, entry="packages")
     */
    private $packages;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\Package[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\Package>")
     * @Serializer\XmlList(inline=true, entry="namespaces")
     */
    private $namespaces;

    /**
     * @var \Codex\Phpdoc\Serializer\ManifestFile[]
     * @Serializer\Type("array<string,Codex\Phpdoc\Serializer\ManifestFile>")
     * @Serializer\XmlList(inline=true, entry="files")
     */
    private $files;

    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute()
     */
    private $lastModified;

    /**
     * @var \Codex\Revision|\Codex\Contracts\Revision
     * @Serializer\Exclude()
     */
    protected $_revision;

    /**
     * @var \Codex\Phpdoc\Serializer\AddonConfig
     * @Serializer\Type("Codex\Phpdoc\Serializer\AddonConfig")
     */
    private $config;

    /**
     * hasFullName method.
     *
     * @param string $fullName
     *
     * @return bool
     */
    public function hasFullName(string $fullName)
    {
        return array_key_exists(str_ensure_left($fullName, '\\'), $this->files);
    }

    /**
     * getByFullName method.
     *
     * @param string $fullName
     *
     * @return \Codex\Phpdoc\Serializer\ManifestFile
     */
    public function getByFullName(string $fullName)
    {
        return $this->files[ str_ensure_left($fullName, '\\') ];
    }

    /**
     * getHashByFullName method.
     *
     * @param string $fullName
     *
     * @return string
     */
    public function getHashByFullName(string $fullName)
    {
        return $this->files[ str_ensure_left($fullName, '\\') ]->getHash();
    }

    /**
     * getProject method.
     *
     * @param \Codex\Phpdoc\Structure\File[] $files
     *
     * @return \Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure
     */
    public function createPhpdocStructure(array $files)
    {
        return PhpdocStructure::fromArray([
            'title'      => $this->title,
            'version'    => $this->version,
            'packages'   => $this->packages,
            'namespaces' => $this->namespaces,
            'files'      => $files,
        ])->setManifest($this);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the title value.
     *
     * @param string $title
     *
     * @return Manifest
     */
    public function setTitle($title)
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
     * Set the version value.
     *
     * @param string $version
     *
     * @return Manifest
     */
    public function setVersion($version)
    {
        $this->version = $version;

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
     * Set the packages value.
     *
     * @param \Codex\Phpdoc\Serializer\Phpdoc\Package[] $packages
     *
     * @return Manifest
     */
    public function setPackages($packages)
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
     * Set the namespaces value.
     *
     * @param \Codex\Phpdoc\Serializer\Phpdoc\Package[] $namespaces
     *
     * @return Manifest
     */
    public function setNamespaces($namespaces)
    {
        $this->namespaces = $namespaces;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * Set the files value.
     *
     * @param string[] $files
     *
     * @return Manifest
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * setFile method.
     *
     * @param string $key
     * @param        $value
     *
     * @return $this
     */
    public function setFile(string $key, $value)
    {
        if ( ! $value instanceof ManifestFile) {
            $file = new ManifestFile();
            $file
                ->setType($value[ 'type' ])
                ->setName($value[ 'name' ])
                ->setHash($value[ 'hash' ]);
            $value = $file;
        }
        $this->files[ $key ] = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getLastModified(): int
    {
        return $this->lastModified ?? 0;
    }

    /**
     * Set the lastModified value.
     *
     * @param int $lastModified
     *
     * @return Manifest
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * @return \Codex\Contracts\Revision|\Codex\Revision
     */
    public function getRevision()
    {
        return $this->_revision;
    }

    /**
     * @param \Codex\Contracts\Revisions\Revision|\Codex\Revisions\Revision $_revision
     *
     * @return Manifest
     */
    public function setRevision(Revision $_revision)
    {
        $this->_revision = $_revision;
        $this->setConfig(
            AddonConfig::fromArray($_revision->attr('phpdoc', []))
        );

        return $this;
    }

    /**
     * @return \Codex\Phpdoc\Serializer\AddonConfig
     */
    public function getConfig(): \Codex\Phpdoc\Serializer\AddonConfig
    {
        return $this->config;
    }

    /**
     * Set the config value.
     *
     * @param \Codex\Phpdoc\Serializer\AddonConfig $config
     *
     * @return Manifest
     */
    public function setConfig(AddonConfig $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return string
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("project")
     * @Serializer\Type("string")
     */
    public function getProjectKey(): string
    {
        return $this->getRevision()->getProject()->getKey();
    }

    /**
     * @return string
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("revision")
     * @Serializer\Type("string")
     */
    public function getRevisionKey(): string
    {
        return $this->getRevision()->getKey();
    }
}
