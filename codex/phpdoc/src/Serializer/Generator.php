<?php

namespace Codex\Phpdoc\Serializer;

use Codex\Concerns\HasEvents;
use Codex\Contracts\Revisions\Revision;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Illuminate\Filesystem\Filesystem;

class Generator
{
    use HasEvents;

    protected static $eventNamePrefix = 'codex.phpdoc';

    /** @var string */
    protected $destinationPath;

    /** @var \Codex\Contracts\Revisions\Revision */
    protected $revision;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    /**
     * Generator constructor.
     *
     * @param string                              $baseGeneratePath
     * @param \Codex\Contracts\Revisions\Revision $revision
     * @param \Illuminate\Filesystem\Filesystem   $fs
     */
    public function __construct(string $baseGeneratePath, Revision $revision, Filesystem $fs)
    {
        $this->destinationPath = path_njoin($baseGeneratePath, $revision->getProject()->getKey(), $revision->getKey());
        $this->revision        = $revision;
        $this->fs              = $fs;

        if(!$fs->exists($this->destinationPath)) {
            $fs->makeDirectory($this->destinationPath, 0755, true);
        }
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

        return $this->getManifest()->getLastModified() !== $this->getLastModified();
    }

    /**
     * Generates the PHPDoc export files.
     *
     * @param int $flags
     *
     * @return mixed
     */
    public function generate($force = false)
    {
        if (false === $force && false === $this->shouldGenerate()) {
            return;
        }

        $revision = $this->revision;
        $phpdoc   = PhpdocStructure::deserialize($this->readXml(), 'xml');

        // manifest
        $manifest = $phpdoc->getManifest();
        $manifest
            ->setRevision($revision)
            ->setLastModified($this->getLastModified())
            ->serializeToFile($this->path('manifest.php'));
        $this->fireEvent('generated.manifest', $this, $manifest);

        // full (unsplitted)
        $phpdoc->serializeToFile($this->path('full.php'));
        $this->fireEvent('generated.full', $this, $manifest);

        // files
        $files = $phpdoc->getFiles();
        $total = count($files);
        foreach ($files as $i => $file) {
            $entity = $file->getEntity();
            $file->serializeToFile($this->path($file->getHash()));
            $this->fireEvent('generated.file', $this, $file, $i, $total);
        }
        $this->fireEvent('generated.files', $this, $files);
    }

    protected function getXmlPath()
    {
        return $this->revision->path($this->revision->attr('php.xml_path', 'structure.xml'));
    }

    protected function getLastModified()
    {
        return $this->revision->getFiles()->lastModified($this->getXmlPath());
    }

    protected function readXml()
    {
        return $this->revision->getFiles()->get($this->getXmlPath());
    }

    public function path(...$parts)
    {
        return path_njoin($this->destinationPath, ...$parts);
    }

    public function hasManifest()
    {
        return $this->fs->exists($this->path('manifest.php'));
    }

    /** @var \Codex\Phpdoc\Serializer\Manifest */
    protected $manifest;

    /**
     * getManifest method.
     *
     * @return \Codex\Phpdoc\Serializer\Manifest
     */
    public function getManifest()
    {
        if (null === $this->manifest) {
            $this->manifest = Manifest::deserializeFromFile($this->path('manifest.php'));
            $this->manifest->setRevision($this->revision);
        }

        return $this->manifest;
    }
}
