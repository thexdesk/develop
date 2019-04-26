<?php

namespace Codex\Phpdoc;

use Codex\Concerns\HasCallbacks;
use Codex\Contracts\Revisions\Revision;
use Codex\Exceptions\MissingFileException;
use Codex\Filesystem\Temp;
use Codex\Phpdoc\Serializer\Manifest;
use Codex\Phpdoc\Serializer\Phpdoc\File;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;

class RevisionPhpdoc
{
    use HasCallbacks;

    /** @var \Codex\Contracts\Revisions\Revision */
    protected $revision;

    /** @var string */
    protected $path;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    /** @var PhpdocStructure */
    protected $full;

    /** @var File[] */
    protected $files = [];


    public function __construct(Revision $revision)
    {
        $this->path     = path_njoin(config('codex-phpdoc.paths.generated'), $revision->getProject()->getKey(), $revision->getKey());
        $this->revision = $revision;
        $this->fs       = app('files');
    }

    public function clear()
    {
        $this->fs->deleteDirectory($this->path);
        return $this;
    }

    public function generate($force = false)
    {
        if (false === $force && false === $this->shouldGenerate()) {
            return $this;
        }


        $structure = PhpdocStructure::deserialize($this->getXml(), 'xml'); //        $this->ensureGeneratedDirectory();

        $this->fire('generate', [ $this, $structure ]);

        $this->clear();

        // Generate all files in a tmp dir first, then move the dir once all complete
        $tmp = new Temp(md5($this->path));
        $tmp->initRunFolder(true);
        $createTmpFile = function ($path) use ($tmp) {
            $path = path_relative($path, $this->path);
            $path = str_ensure_right($path, '.php');
            return $tmp->createFile($path); //->getRealPath();
        };

        // manifest
        $manifest = $structure->getManifest();
        $manifest->setPhpdoc($this);

        $manifest->serializeToFile((string)$createTmpFile($this->getManifestPath()));
        $this->fire('generated.manifest', [ $this, $manifest ]);

        // full (unsplitted)
        $structure->serializeToFile((string)$createTmpFile($this->path('full.php')));
        $this->fire('generated.full', [ $this, $manifest ]);

        // files
        $files = $structure->getFiles();
        $total = count($files);
        foreach ($files as $i => $file) {
            $filePath = $createTmpFile($this->path($file->getHash()));
            $file->serializeToFile((string)$filePath);
            $this->fire('generated.file', [ $this, $filePath, $file, $i, $total ]);
        }
        $this->fire('generated.files', [ $this, $files ]);

        $tmp->moveDirTo($this->path);

        $this->fire('generated', [ $this, $structure ]);
        return $this;
    }

    public function getRevision()
    {
        return $this->revision;
    }

    public function isEnabled()
    {
        return $this->revision->attr('phpdoc.enabled', false);
    }

    public function getTitle()
    {
        return $this->revision->attr('phpdoc.title');
    }

    public function getXmlPath()
    {
        return $this->revision->path($this->revision->attr('phpdoc.xml_path'));
    }

    public function getDefaultClass()
    {
        return $this->revision->attr('phpdoc.default_class');
    }

    public function hasXmlFile()
    {
        return $this->revision->getFiles()->exists($this->getXmlPath());
    }

    public function getXmlLastModified()
    {
        return $this->revision->getFiles()->lastModified($this->getXmlPath());
    }

    public function getXml()
    {
        return $this->revision->getFiles()->get($this->getXmlPath());
    }

    public function path(...$parts)
    {
        return path_njoin($this->path, ...$parts);
    }

    public function ensureGeneratedDirectory()
    {
        if ( ! $this->fs->exists($this->path)) {
            $this->fs->makeDirectory($this->path, 0755, true);
        }
        return $this;
    }

    public function shouldGenerate()
    {
        if ( ! $this->isGenerated()) {
            return true;
        }

        return $this->getManifest()->getLastModified() !== $this->getXmlLastModified();
    }

    public function isGenerated()
    {
        if ( ! $this->isEnabled()) {
            return false;
        }
        return $this->fs->exists($this->getManifestPath());
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getManifestPath()
    {
        return $this->path(Manifest::FILE_NAME);
    }

    /** @var \Codex\Phpdoc\Serializer\Manifest */
    private $manifest;

    /**
     * getManifest method.
     *
     * @return \Codex\Phpdoc\Serializer\Manifest
     */
    public function getManifest()
    {
        if (null === $this->manifest) {
            $this->manifest = Manifest::deserializeFromFile($this->getManifestPath());
            $this->manifest->setPhpdoc($this);
        }

        return $this->manifest;
    }

    public function getFull()
    {
        if (null === $this->full) {
            $this->full = PhpdocStructure::deserializeFromFile($this->path('full.php'));
        }

        return $this->full;
    }

    public function getFile(string $hash)
    {
        if (false === array_key_exists($hash, $this->files)) {
            $this->files[ $hash ] = File::deserializeFromFile($this->path($hash . '.php'));
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
