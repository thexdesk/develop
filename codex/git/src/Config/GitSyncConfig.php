<?php


namespace Codex\Git\Config;


use Codex\Git\Connection\Ref;
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

    public function getCleanPaths()
    {

    }
}
