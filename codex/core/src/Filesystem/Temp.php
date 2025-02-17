<?php

namespace Codex\Filesystem;

use Codex\Exceptions\InvalidArgumentException;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;

class Temp
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var String
     */
    protected $prefix;

    /**
     * @var \SplFileInfo[]
     */
    protected $files = [];

    /**
     * @var Bool
     */
    protected $preserveRunFolder = false;

    /**
     *
     * If temp folder needs to be deterministic, you can use ID as the last part of folder name
     *
     * @var string
     */
    protected $id = '';

    public function __construct($prefix = '', Filesystem $fs = null)
    {
        $this->prefix     = $prefix;
        $this->filesystem = $fs ?? new Filesystem();
        $this->id         = md5(uniqid($prefix, true));
    }

    public function initRunFolder($clean=false)
    {
        clearstatcache();
        $path = $this->getTmpPath();
        if ($clean && is_dir($path)) {
            $this->filesystem->remove($path);
        }
        if ( ! file_exists($path) && ! is_dir($path)) {
            $this->filesystem->mkdir($path, 0755);
        }
    }

    /**
     * @param bool $value
     */
    public function setPreserveRunFolder($value)
    {
        $this->preserveRunFolder = $value;
    }

    /**
     * Get path to temp directory
     *
     * @return string
     */
    protected function getTmpPath()
    {
        $tmpDir = sys_get_temp_dir();
        if ( ! empty($this->prefix)) {
            $tmpDir .= '/' . $this->prefix;
        }
        $tmpDir .= '/' . $this->id;
        return $tmpDir;
    }

    /**
     * Returns path to temp folder for current request
     *
     * @return string
     */
    public function getTmpFolder()
    {
        return $this->getTmpPath();
    }

    /**
     * Create empty file in TMP directory
     *
     * @param string $suffix filename suffix
     * @param bool   $preserve
     *
     * @return \SplFileInfo
     * @throws \Exception
     */
    public function createTmpFile($suffix = null, $preserve = false)
    {
        $this->initRunFolder();
        $file = uniqid('file-', true);
        if ($suffix) {
            $file .= '-' . $suffix;
        }
        $fileInfo = new SplFileInfo($this->getTmpPath() . '/' . $file);
        $this->filesystem->touch($fileInfo);
        $this->files[] = [
            'file'     => $fileInfo,
            'preserve' => $preserve,
        ];
        $this->filesystem->chmod($fileInfo, 0600);
        return $fileInfo;
    }

    /**
     * Creates named temporary file
     *
     * @param      $fileName
     * @param bool $preserve
     *
     * @return \SplFileInfo
     * @throws \Exception
     */
    public function createFile($fileName, $preserve = false)
    {
        $this->initRunFolder();
        $fileInfo = new SplFileInfo($this->getTmpPath() . '/' . $fileName);
        $this->filesystem->touch((string)$fileInfo);
//        $file          = $fileInfo->openFile('r+');
        $this->files[] = [
            'file'     => $fileInfo,
            'preserve' => $preserve,
        ];
        $this->filesystem->chmod((string)$fileInfo, 0600);
        return $fileInfo;
    }

    public function moveDirTo($path)
    {
        if ($this->filesystem->exists($path)) {
            throw InvalidArgumentException::make("Could not move temporary directory to {$path}. Destination directory already exists");
        }
        $dirPath = dirname($path);
        if ( ! $this->filesystem->exists($dirPath)) {
            if ( ! mkdir($dirPath, 0755, true) && ! is_dir($dirPath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
        $this->filesystem->rename($this->getTmpFolder(), $path);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Destructor
     *
     * Delete all files created by syrup component run
     */
    function __destruct()
    {
        $preserveRunFolder = $this->preserveRunFolder;
        $fs                = new Filesystem();
        foreach ($this->files as $file) {
            if ($file[ 'preserve' ]) {
                $preserveRunFolder = true;
            }
            if (file_exists($file[ 'file' ]) && is_file($file[ 'file' ]) && ! $file[ 'preserve' ]) {
                $fs->remove($file[ 'file' ]);
            }
        }
        if ( ! $preserveRunFolder) {
            if ($fs->exists($this->getTmpPath())) {
                $fs->remove($this->getTmpPath());
            }
        }
    }
}
