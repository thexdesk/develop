<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc;

use Codex\Phpdoc\Events\GeneratorEvent;
use Codex\Phpdoc\Serializer\Manifest;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Codex\Contracts\Revision;
use Codex\Support\BitwiseFlag;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;

class Generator extends BitwiseFlag implements Contracts\Generator
{
    const FLAG_MANIFEST = 0;

    const FLAG_FILES = 1;

    const FLAG_PROJECT = 2;

    const FLAG_FORCE = 4;

    /** @var string */
    protected $xml;

    /** @var string */
    protected $destinationPath;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $lfs;

    /** @var int */
    protected $xmlLastModified;

    /** @var \Codex\Contracts\Revision|\Codex\Revision */
    protected $revision;

    /** @var PhpdocStructure */
    protected $phpdoc;

    /**
     * Generator constructor.
     *
     * @param \Illuminate\Filesystem\Filesystem       $lfs
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     */
    public function __construct(Filesystem $lfs)
    {
        $this->lfs = $lfs;
    }

    /**
     * Set the path to the directory to write all files in.
     *
     * @param string $destinationPath
     *
     * @return static
     */
    public function setDestinationPath(string $destinationPath)
    {
        $this->destinationPath = $destinationPath;

        return $this;
    }

    /**
     * Set the XML string provided by a PHPDoc generated structure.xml file.
     *
     * @param string $xml
     *
     * @return static
     */
    public function setXml(string $xml)
    {
        $this->xml = $xml;

        return $this;
    }

    /**
     * setXmlLastModified method.
     *
     * @param int $xmlLastModified
     *
     * @return $this
     */
    public function setXmlLastModified(int $xmlLastModified)
    {
        $this->xmlLastModified = $xmlLastModified;

        return $this;
    }

    /**
     * setRevision method.
     *
     * @param \Codex\Contracts\Revision $revision
     *
     * @return $this
     */
    public function setRevision(Revision $revision)
    {
        $this->revision = $revision;

        return $this;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Generates the PHPDoc export files.
     *
     * @param int $flags
     *
     * @return mixed
     */
    public function generate($flags = self::FLAG_MANIFEST | self::FLAG_FILES)
    {
        $this->flags = $flags;

        if (null === $this->destinationPath || null === $this->xml || null === $this->xmlLastModified) {
            throw new RuntimeException('One of the required properties is not set');
        }

        if (false === $this->isFlagSet(self::FLAG_FORCE) && false === $this->shouldGenerate()) {
            return;
        }

        $this->phpdoc = PhpdocStructure::deserialize($this->xml, 'xml');
        $this->fireEvent(GeneratorEvent::START);
        if ($this->isFlagSet(self::FLAG_MANIFEST)) {
            $manifest = $this->phpdoc->getManifest();
            if (null !== $this->revision) {
                $manifest->setRevision($this->revision);
            }
            $this->fireEvent(GeneratorEvent::GENERATE, null, self::FLAG_MANIFEST);
            $manifest
                ->setLastModified($this->xmlLastModified)
                ->serializeToFile($path = $this->path('manifest'));
            $this->fireEvent(GeneratorEvent::GENERATED, $path, self::FLAG_MANIFEST);
        }
        if ($this->isFlagSet(self::FLAG_PROJECT)) {
            $this->fireEvent(GeneratorEvent::GENERATE, self::FLAG_PROJECT);
            $this->phpdoc->serializeToFile($path = $this->path('project'));
            $this->fireEvent(GeneratorEvent::GENERATED, $path, self::FLAG_PROJECT);
        }
        if ($this->isFlagSet(self::FLAG_FILES)) {
            $files = $this->phpdoc->getFiles();
            $totalFiles = \count($files);
            foreach ($files as $i => $file) {
                $entity = $file->getEntity();
                $context = null === $entity ? $file->getPath() : $entity->getFullName();
                $this->fireEvent(GeneratorEvent::GENERATE, $context, self::FLAG_FILES);
                $file->serializeToFile($this->path($file->getHash()));
                $this->fireEvent(GeneratorEvent::GENERATED, "({$i}/{$totalFiles}): ".$context, self::FLAG_FILES);
            }
        }
        $this->fireEvent(GeneratorEvent::END);
    }

    protected function fireEvent(string $name, string $context = null, int $flag = null)
    {
        event(new GeneratorEvent($name, $this, $context, $flag));
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure
     */
    public function getPhpdocStructure(): \Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure
    {
        return $this->phpdoc;
    }

    /**
     * Checks against the lastModified if generation is needed.
     *
     * @return bool
     */
    public function shouldGenerate()
    {
        if (false === $this->hasManifest()) {
            return true;
        }

        return $this->getManifest()->getLastModified() !== $this->xmlLastModified;
    }

    /** @var \Codex\Phpdoc\Serializer\Manifest */
    protected $manifest;

    /**
     * getManifest method.
     *
     * @return \Codex\Phpdoc\Serializer\Manifest
     */
    protected function getManifest(): Manifest
    {
        if (null === $this->manifest) {
            $this->manifest = Manifest::deserializeFromFile($this->path('manifest.php'));
        }

        return $this->manifest;
    }

    /**
     * hasManifest method.
     *
     * @return bool
     */
    protected function hasManifest(): bool
    {
        return $this->lfs->exists($this->path('manifest.php'));
    }

    /**
     * path method.
     *
     * @param string[] ...$path
     *
     * @return mixed|string
     */
    protected function path(string ...$path)
    {
        return null === $path ? $this->destinationPath : path_join($this->destinationPath, ...$path);
    }
}
