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
use Codex\Phpdoc\RevisionPhpdoc;
use Codex\Phpdoc\Serializer\Annotations\Attr;
use Codex\Phpdoc\Serializer\Concerns\DeserializeFromFile;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Concerns\SerializeToFile;
use Codex\Phpdoc\Serializer\Concerns\WithResponse;
use Illuminate\Contracts\Support\Responsable;
use JMS\Serializer\Annotation as Serializer;


class Manifest implements SelfSerializable, Responsable
{
    const FILE_NAME = 'manifest.php';

    use SerializesSelf,
        DeserializeFromFile,
        SerializeToFile,
        WithResponse;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $title;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $version;

    /**
     * @var integer
     * @Serializer\Accessor(getter="getLastModified")
     * @Serializer\SerializedName("last_modified")
     * @Serializer\Type("integer")
     * @Attr()
     */
    private $last_modified;

    /**
     * @var string
     * @Serializer\Accessor(getter="getDefaultClass")
     * @Serializer\SerializedName("default_class")
     * @Serializer\Type("string")
     * @Attr()
     */
    private $default_class;

    /**
     * @var string
     * @Serializer\Accessor(getter="getProjectKey")
     * @Serializer\SerializedName("project")
     * @Serializer\Type("string")
     * @Attr()
     */
    private $project;

    /**
     * @var string
     * @Serializer\Accessor(getter="getRevisionKey")
     * @Serializer\SerializedName("revision")
     * @Serializer\Type("string")
     * @Attr()
     */
    private $revision;

    /**
     * @var \Codex\Phpdoc\Serializer\ManifestFile[]
     * @Serializer\Type("LaravelCollection<Codex\Phpdoc\Serializer\ManifestFile>")
     * @Serializer\XmlList(inline=true, entry="files")
     * @Attr(new=true, array=true)
     */
    private $files;

    /**
     * @var \Codex\Phpdoc\RevisionPhpdoc
     * @Serializer\Exclude()
     */
    protected $phpdoc;

    public function getLastModified()
    {
        return $this->phpdoc->getXmlLastModified() ?? 0;
    }

    public function getDefaultClass()
    {
        return str_ensure_left($this->phpdoc->getDefaultClass(), '\\');
    }

    public function getProjectKey()
    {
        return $this->phpdoc->getRevision()->getProject()->getKey();
    }

    public function getRevisionKey()
    {
        return $this->phpdoc->getRevision()->getKey();
    }

    /**
     * hasFullName method.
     *
     * @param string $fullName
     *
     * @return bool
     */
    public function hasFullName(string $fullName)
    {
        $fullName = str_ensure_left($fullName, '\\');
        foreach ($this->files as $file) {
            if ($file->getName() === $fullName) {
                return true;
            }
        }
        return false;
//        return array_key_exists(str_ensure_left($fullName, '\\'), $this->files);
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
        $fullName = str_ensure_left($fullName, '\\');
        foreach ($this->files as $file) {
            if ($file->getName() === $fullName) {
                return $file;
            }
        }
        return null;
//        return $this->files[ str_ensure_left($fullName, '\\') ];
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
        return $this->getByFullName($fullName)->getHash();
//        return $this->files[ str_ensure_left($fullName, '\\') ]->getHash();
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
     * @return \Codex\Phpdoc\Serializer\Handler\LaravelCollection|\Codex\Phpdoc\Serializer\ManifestFile[]
     */
    public function getFiles()
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
                ->setName($key)
                ->setHash($value[ 'hash' ]);
            $value = $file;
        }

        $this->files[] = $value;

        return $this;
    }

    public function setPhpdoc(RevisionPhpdoc $phpdoc)
    {
        $this->phpdoc = $phpdoc;
        return $this;
    }

}
