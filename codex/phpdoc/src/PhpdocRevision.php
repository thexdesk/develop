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

use Codex\Phpdoc\Commands\GenerateRevisionPhpdoc;
use Codex\Phpdoc\Contracts\PhpdocProject;
use Codex\Phpdoc\Serializer\Manifest;
use Codex\Phpdoc\Serializer\Phpdoc\File;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Codex\Contracts\Revision;
use Codex\Exceptions\MissingFileException;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Filesystem\Filesystem;

class PhpdocRevision implements Contracts\PhpdocRevision
{
    /** @var \Codex\Contracts\Revision */
    protected $revision;

    /** @var \Illuminate\Contracts\Cache\Repository */
    protected $cache;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $lfs;

    /** @var \Codex\Phpdoc\Commands\GenerateRevisionPhpdoc */
    protected $generateCommand;

    /** @var string */
    protected $destinationPath;

    /** @var \Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure */
    protected $project;

    /** @var \Codex\Phpdoc\Serializer\Phpdoc\File[] */
    protected $files = [];

    /** @var \Codex\Phpdoc\Serializer\Manifest */
    protected $manifest;

    /**
     * RevisionDoc constructor.
     *
     * @param \Codex\Contracts\Revision              $parent
     * @param \Illuminate\Contracts\Cache\Repository $cache
     * @param \Illuminate\Filesystem\Filesystem      $lfs
     */
    public function __construct(Revision $parent, Repository $cache, Filesystem $lfs)
    {
        $this->revision = $parent;
        $this->cache = $cache;
        $this->lfs = $lfs;
        if ($this->isEnabled()) {
            $this->generateCommand = new GenerateRevisionPhpdoc($this->revision);
            $this->destinationPath = path_join(config('codex-phpdoc.storage.path'), $this->revision->getProject()->getKey(), $this->revision->getKey());
        }
    }

    public function url($fullName = null)
    {
    }

    public function isEnabled()
    {
        return true === $this->revision->config('phpdoc.enabled', false);
    }

    public function generate($queue = true, $flags = 0): Contracts\PhpdocRevision
    {
        // if($this->generateCommand->getGenerator()->shouldGenerate()){}
        $this->generateCommand->dispatch($queue);

        return $this;
    }

    public function getManifest(): Manifest
    {
        if (null === $this->manifest) {
            $this->manifest = Manifest::deserializeFromFile($this->path('manifest.php'));
            $this->manifest->setRevision($this->revision);
        }

        return $this->manifest;
    }

    public function getFull(): PhpdocStructure
    {
        if (null === $this->project) {
            $this->project = PhpdocStructure::deserializeFromFile($this->path('project.php'));
        }

        return $this->project;
    }

    public function getFile(string $hash): File
    {
        if (false === array_key_exists($hash, $this->files)) {
            $this->files[$hash] = File::deserializeFromFile($this->path($hash.'.php'));
        }

        return $this->files[$hash];
    }

    public function getFileByFullName(string $fullName): File
    {
        if (false === $this->getManifest()->hasFullName($fullName)) {
            throw MissingFileException::file($fullName);
        }

        return $this->getFile($this->getManifest()->getHashByFullName($fullName));
    }

    public function path(string ...$path)
    {
        return 0 === \count($path) ? $this->destinationPath : path_join($this->destinationPath, ...$path);
    }

    public function getRevision(): Revision
    {
        return $this->revision;
    }

    public function getProject(): PhpdocProject
    {
        return $this->revision->getProject()->phpdoc;
    }

    /**
     * @return string
     */
    public function getDestinationPath(): string
    {
        return $this->destinationPath;
    }
}
