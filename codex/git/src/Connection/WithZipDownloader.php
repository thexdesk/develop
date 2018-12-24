<?php


namespace Codex\Git\Connection;


use Codex\Git\Drivers\DriverInterface;

trait WithZipDownloader
{
    /** @var \Codex\Git\Connection\ZipDownloader|null */
    protected $zipDownloader;

    /** @return \Codex\Git\Connection\ZipDownloader */
    public function getZipDownloader()
    {
        if (null === $this->zipDownloader) {
            $this->zipDownloader = app()->make(ZipDownloader::class);
            if ($this instanceof DriverInterface) {
                $this->zipDownloader->setDriver($this);
            }
        }
        return $this->zipDownloader;
    }
}
