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

namespace Codex\Git\Connection;

use Codex\Git\Drivers\DriverInterface;
use Symfony\Component\Process\ExecutableFinder;
use ZipArchive;

class ZipDownloader
{
    protected static $hasSystemUnzip;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    /** @var string */
    protected $tmpPath;

    /** @var \Codex\Git\Drivers\DriverInterface */
    protected $driver;


    /**
     * ZipDownloader constructor.
     *
     * @param \Illuminate\Filesystem\Filesystem $fs
     */
    public function __construct(\Illuminate\Filesystem\Filesystem $fs)
    {
        $this->fs      = $fs;
        $this->tmpPath = storage_path('codex/git');
    }

    /**
     * setDriver method.
     *
     * @param \Codex\Git\Drivers\DriverInterface $driver
     *
     * @return $this
     */
    public function setDriver(DriverInterface $driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * Set the tmpPath value.
     *
     * @param string $tmpPath
     *
     * @return ZipDownloader
     */
    public function setTmpPath($tmpPath)
    {
        $this->tmpPath = $tmpPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getTmpPath(): string
    {
        return $this->tmpPath;
    }

    /**
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFs(): \Illuminate\Filesystem\Filesystem
    {
        return $this->fs;
    }

    /**
     * Set the fs value.
     *
     * @param \Illuminate\Filesystem\Filesystem $fs
     *
     * @return ZipDownloader
     */
    public function setFs($fs)
    {
        $this->fs = $fs;

        return $this;
    }

    private function remakeDirectory(string $path)
    {
        if ($this->fs->exists($path)) {
            $this->fs->cleanDirectory($path);
            $this->fs->deleteDirectory($path);
        }
        $this->fs->makeDirectory($path, 0755, true, true);

        return $this;
    }

    public function cleanRootPath()
    {
        $this->remakeDirectory($this->tmpPath);

        return $this;
    }

    public function download($url, $cache = true)
    {
        // Check up on method to zip
        $this->hasUnzipCapabilities();

        $urlHash = md5($url);

        // prepare new temporary directory
        $tmpExtractPath = $this->tmpPath . \DIRECTORY_SEPARATOR . $urlHash;
        $tmpFilePath    = $tmpExtractPath . '.zip';

        if ( ! $cache) {
            $this->remakeDirectory($tmpExtractPath);

            if ($this->fs->exists($tmpFilePath)) {
                $this->fs->delete($tmpFilePath);
            }
        }
        if ( ! $this->fs->exists($tmpFilePath)) {
            $contents = $this->driver->downloadFile($url);
            $this->fs->put($tmpFilePath, $contents);
        }

        if ( ! $this->fs->exists($tmpExtractPath)) {
            $zip = new ZipArchive();
            $zip->open($tmpFilePath);
            $zip->extractTo($tmpExtractPath);
        }

        if ( ! $cache) {
            $this->fs->delete($tmpFilePath);
        }
        return new ZipDownloaderResult($this, $tmpExtractPath);
    }

    protected function hasUnzipCapabilities()
    {
        if (null === self::$hasSystemUnzip) {
            $finder               = new ExecutableFinder();
            self::$hasSystemUnzip = (bool)$finder->find('unzip');
        }
        if ( ! class_exists('ZipArchive') && ! self::$hasSystemUnzip) {
            // php.ini path is added to the error message to help users find the correct file
            $iniPath = php_ini_loaded_file();
            if ($iniPath) {
                $iniMessage = 'The php.ini used by your command-line PHP is: ' . $iniPath;
            } else {
                $iniMessage = 'A php.ini file does not exist. You will have to create one.';
            }
            $error = "The zip extension and unzip command are both missing, skipping.\n" . $iniMessage;
            throw new \RuntimeException($error);
        }
    }
}
