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

use ArrayAccess;
use Codex\Git\Drivers\DriverInterface;
use Illuminate\Contracts\Support\Arrayable;
use vierbergenlars\SemVer\version;

class Ref implements ArrayAccess, Arrayable
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /** @var string */
    protected $hash;

    /** @var string */
    protected $downloadUrl;

    /** @var version */
    protected $version;

    /** @var int */
    protected $major;

    /** @var int */
    protected $minor;

    /** @var int */
    protected $patch;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        if ($this->isTag() && $this->getVersion()->valid()) {
            list($this->major, $this->minor, $this->patch) = $this->getVersionSegments();
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * isBranch method.
     *
     * @return bool
     */
    public function isBranch()
    {
        return 'branch' === $this->type;
    }

    /**
     * isTag method.
     *
     * @return bool
     */
    public function isTag()
    {
        return 'tag' === $this->type;
    }

    /**
     * getVersion method.
     *
     * @return \vierbergenlars\SemVer\version
     */
    public function getVersion()
    {
        if (null === $this->version && $this->isTag()) {
            $this->version = new version($this->name);
        }

        return $this->version;
    }

    public function getVersionSegments()
    {
        $version = $this->getVersion();

        return [$version->getMajor(), $version->getMinor(), $version->getPatch()];
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getDownloadUrl(): string
    {
        return $this->downloadUrl;
    }

//    public function getZipDownloader(DriverInterface $driver)
//    {
//        $downloader = app()->make(ZipDownloader::class);
//
//        return $downloader->download($this->getDownloadUrl());
//    }

    /**
     * getCacheKey method.
     *
     * @return string
     */
    public function getCacheKey()
    {
        return 'codex.git.'.md5($this->type.$this->name);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $version = $this->isTag() ? $this->getVersion() : null;

        return [
            'name' => $this->name,
            'type' => $this->type,
            'hash' => $this->hash,
            'downloadUrl' => $this->downloadUrl,
            'cacheKey' => $this->getCacheKey(),
            'version' => (string) $version,
            'major' => $this->major,
            'minor' => $this->minor,
            'patch' => $this->patch,
        ];
    }

    /**
     * Whether a offset exists.
     *
     * @see  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned
     *
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Offset to retrieve.
     *
     * @see  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed can return all value types
     *
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Offset to set.
     *
     * @see  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        return $this->$offset = $value;
    }

    /**
     * Offset to unset.
     *
     * @see  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
}
