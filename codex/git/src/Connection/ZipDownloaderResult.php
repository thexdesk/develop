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

class ZipDownloaderResult
{
    /** @var \Codex\Git\Connection\ZipDownloader */
    protected $downloader;

    /** @var string */
    protected $extractedPath;

    public function __construct(ZipDownloader $downloader, $tmpExtractPath)
    {
        $this->downloader = $downloader;
        $this->extractedPath = $this->getFs()->directories($tmpExtractPath)[0];
    }

    public function clean()
    {
        $fs = $this->getFs();
        $path = $this->getFs()->dirname($this->getExtractedPath());
        $fs->cleanDirectory($path);
        $fs->deleteDirectory($path);

        return $this;
    }

    public function getExtractedPath()
    {
        return $this->extractedPath;
    }

    public function getFs()
    {
        return $this->downloader->getFs();
    }

    public function getDownloader()
    {
        return $this->downloader;
    }
}
