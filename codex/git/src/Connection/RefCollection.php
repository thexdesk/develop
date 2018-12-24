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

use Illuminate\Support\Collection;

/**
 * This is the class RefCollection.
 *
 * @author  Robin Radic
 *
 * @method Ref   get($key, $default = null)
 * @method Ref[] all()
 * @method Ref[] toArray()
 */
class RefCollection extends Collection
{
    /**
     * @var Ref[]
     */
    protected $items = [];

    /**
     * branches method.
     *
     * @return \Codex\Git\Connection\RefCollection|\Codex\Git\Connection\Ref[]
     */
    public function branches()
    {
        return $this->where('type', 'branch');
    }

    /**
     * tags method.
     *
     * @return \Codex\Git\Connection\RefCollection|\Codex\Git\Connection\Ref[]
     */
    public function tags()
    {
        return $this->where('type', 'tag');
    }

    public function whereMajorVersion($major)
    {
        return $this->tags()->reject(function (Ref $ref) use ($major) {
            return $ref->getVersion()->getMajor() !== (int) $major;
        });
    }

    public function whereMinorVersion($major, $minor)
    {
        return $this
            ->whereMajorVersion($major)
            ->reject(function (Ref $ref) use ($minor) {
                return $ref->getVersion()->getMinor() !== (int) $minor;
            });
    }

    public function getFirstMinor($major)
    {
        $refs = $this->whereMajorVersion($major);
        $minor = $refs->min(function (Ref $ref) {
            return $ref->getVersion()->getMinor();
        });
        $ref = $refs->keyBy(function (Ref $ref) {
            return $ref->getVersion()->getMinor();
        })->get($minor);

        return $ref;
    }

    public function getFirstPatch($major, $minor)
    {
        $refs = $this->whereMinorVersion($major, $minor);

        $patch = $refs->min(function (Ref $ref) {
            return $ref->getVersion()->getPatch();
        });

        $ref = $refs->keyBy(function (Ref $ref) {
            return $ref->getVersion()->getPatch();
        })->get($patch);

        return $ref;
    }

    public function keyByVersionSegments()
    {
        /** @var static|static[]|static[][] $versions */
        $versions = new static();
        $this->tags()->each(function (Ref $ref) use (&$versions) {
            if (!$versions->has($ref['major'])) {
                $versions->put($ref['major'], new static());
            }
            if (!$versions[$ref['major']]->has($ref['minor'])) {
                $versions[$ref['major']]->put($ref['minor'], new static());
            }
            $versions[$ref['major']][$ref['minor']]->put($ref['patch'], $ref);
        });

        return $versions;
    }

    public function skipPatchVersions()
    {
        $versions = new static();
        foreach ($this->keyByVersionSegments() as $major => $minors) {
            foreach ($minors as $minor => $patches) {
                $ref = $patches->getFirstPatch($major, $minor);
                $versions->put((string) $ref->getVersion(), $ref);
            }
        }

        return $versions;
    }

    public function skipMinorVersions()
    {
        $versions = new static();
        foreach ($this->keyByVersionSegments() as $major => $minors) {
            $ref = $minors->getFirstMinor($major);
            $versions->put((string) $ref->getVersion(), $minors->getFirstMinor($major));
        }

        return $versions;
    }
}
