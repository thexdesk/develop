<?php


namespace Codex\Git\Config;


use Codex\Exceptions\InvalidConfigurationException;
use Codex\Git\Connection\Ref;
use Codex\Git\Connection\RefCollection;
use vierbergenlars\SemVer\expression;

class GitSyncConfig extends AbstractGitConfigChild
{
    /** @return \Codex\Git\Config\GitRemoteConfig */
    public function getRemote()
    {
        return $this->getGit()->getRemotes()->get($this->get('remote'));
    }

    public function connection()
    {
        return $this->getRemote()->getConnection();
    }

    public function getVersions()
    {
        return null === $this->get('versions') ? null : new expression($this->get('versions'));
    }

    public function skipsPatchVersions()
    {
        return $this->get('skip.patch_versions', false);
    }

    public function skipsMinorVersions()
    {
        return $this->get('git.skip.minor_versions', false);
    }

    public function shouldSyncRef(Ref $ref)
    {
        if ($ref->isBranch()) {
            return $this->getBranches()->has($ref->getName());
        }
        $versions = $this->getVersions();
        if ($versions !== null && $ref->isTag()) {
            $version = $ref->getVersion();
            if ($versions->satisfiedBy($version)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return \Codex\Git\Connection\RefCollection|Ref[]
     */
    public function getRefs()
    {
        $refs = [];
        foreach ($this->getRemote()->getRefs()->all() as $ref) {
            if ($this->shouldSyncRef($ref)) {
                $destination = $ref->getName();
                if ($ref->isBranch()) {
                    $destination = $this->getBranches()->get($ref->getName());
                }
                $refs[ $destination ] = $ref;
            }
        }
        return RefCollection::make($refs);
    }


    /** @var \Illuminate\Support\Collection|string[] */
    protected $branches;

    /**
     * @return \Illuminate\Support\Collection|string[]
     */
    public function getBranches()
    {
        if ($this->branches === null) {
            $this->branches = collect($this->get('branches'))->mapWithKeys(function ($destination, $name) {
                if (is_numeric($name)) {
                    $name = $destination;
                }

                return [ $name => $destination ];
            });
        }
        return $this->branches;
    }

    /** @var \Illuminate\Support\Collection|string[] */
    protected $copy;

    public function getCopy()
    {
        if ($this->copy === null) {
            $this->copy = collect($this->get('copy'))->mapWithKeys(function ($dest, $src) {
                if (is_numeric($src)) {
                    $src  = $dest;
                    $dest = '';
                }
                $dest = array_map(function ($dest) {
                    return path_absolute($dest, '/');
                }, array_wrap($dest));
                return [ path_absolute($src, '/') => $dest ];
            });
        }
        return $this->copy;
    }

    public function getCleanPaths($prefix = null)
    {
        $clean = $this->get('clean');
        if ( ! $clean) {
            return [];
        }
        if ($clean === true) {
            return [ path_njoin($prefix, '') ];
        }
        if (is_string($clean)) {
            return [ path_njoin($prefix, $clean) ];
        }
        if (is_array($clean)) {
            return array_map(function ($path) use ($prefix) {
                return path_njoin($prefix, $path);
            }, $clean);
        }
        throw InvalidConfigurationException::reason('clean');
    }
}
