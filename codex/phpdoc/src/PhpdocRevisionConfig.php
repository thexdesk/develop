<?php

namespace Codex\Phpdoc;

use Codex\Contracts\Revisions\Revision;
use Codex\Exceptions\MissingFileException;
use Codex\Phpdoc\Serializer\Generator;
use Codex\Phpdoc\Serializer\Manifest;
use Codex\Phpdoc\Serializer\Phpdoc\File;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Illuminate\Filesystem\Filesystem;

class PhpdocRevisionConfig
{
    /** @var \Codex\Contracts\Revisions\Revision */
    protected $revision;

    /** @var \Codex\Phpdoc\Serializer\Generator */
    protected $generator;

    /** @var Manifest */
    protected $manifest;

    /** @var PhpdocStructure */
    protected $full;

    /** @var File[] */
    protected $files = [];

    public function __construct(Revision $revision)
    {
        $this->revision = $revision;
        if ($this->isEnabled()) {
            $this->generator = new Generator(config('codex-phpdoc.paths.generated'), $revision, resolve(Filesystem::class));
        }
    }

    public function isEnabled()
    {
        return $this->revision->attr('phpdoc.enabled', false);
    }

    public function getTitle()
    {
        return $this->revision->attr('phpdoc.title');
    }

    public function getXmlFilePath()
    {
        return $this->revision->attr('phpdoc.xml_path');
    }

    public function getDefaultClass()
    {
        return $this->revision->attr('phpdoc.default_class');
    }

    public function xmlFileExists()
    {
        return $this->revision->getFiles()->exists($this->getXmlFilePath());
    }

    public function isGenerated()
    {
        if(!$this->isEnabled()){
            return false;
        }
        return $this->generator->hasManifest();
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Generator
     */
    public function getGenerator()
    {
        return $this->generator;
    }


    public function getManifest()
    {
        return $this->generator->getManifest();
    }

    public function getFull()
    {
        if (null === $this->full) {
            $this->full = PhpdocStructure::deserializeFromFile($this->generator->path('full.php'));
        }

        return $this->full;
    }

    public function getFile(string $hash)
    {
        if (false === array_key_exists($hash, $this->files)) {
            $this->files[ $hash ] = File::deserializeFromFile($this->generator->path($hash . '.php'));
        }

        return $this->files[ $hash ];
    }

    public function getFileByFullName(string $fullName)
    {
        if (false === $this->getManifest()->hasFullName($fullName)) {
            throw MissingFileException::file($fullName);
        }

        return $this->getFile($this->getManifest()->getHashByFullName($fullName));
    }
}
