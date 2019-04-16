<?php


namespace Codex\Git\Config;


use ArrayAccess;
use Codex\Contracts\Mergable\Model;
use Codex\Git\Contracts\ConnectionManager;
use Codex\Support\HasDotArray;
use Illuminate\Contracts\Support\Arrayable;

class GitConfig implements ArrayAccess, Arrayable
{
    use HasDotArray {
        toArray as protected _toArray;
    }

    /** @var \Codex\Contracts\Mergable\Model */
    protected $model;

    /** @var \Codex\Git\Contracts\ConnectionManager */
    protected $manager;

    /** @var \Illuminate\Support\Collection|\Codex\Git\Config\GitRemoteConfig[] */
    protected $remotes;

    /** @var \Illuminate\Support\Collection|\Codex\Git\Config\GitSyncConfig[] */
    protected $syncs;

    /** @var \Illuminate\Support\Collection|\Codex\Git\Config\GitLinkConfig[] */
    protected $links;

    public function __construct(Model $model, ConnectionManager $manager)
    {
        $this->model   = $model;
        $this->manager = $manager;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getManager(): ConnectionManager
    {
        return $this->manager;
    }

    public function getRemotes()
    {
        if ($this->remotes === null) {
            $this->remotes = collect(array_wrap($this->model[ 'git.remotes' ]))->mapWithKeys(function ($value, $key) {
                return [ $key => new GitRemoteConfig($this, $value, $key) ];
            });
        }
        return $this->remotes;
    }

    public function getLinks()
    {
        if ($this->links === null) {
            $this->links = collect(array_wrap($this->model[ 'git.links.links' ]))->mapWithKeys(function ($value, $key) {
                return [ $key => new GitLinkConfig($this, $value, $key) ];
            });
        }
        return $this->links;
    }

    public function getSyncs()
    {
        if ($this->syncs === null) {
            $this->syncs = collect(array_wrap($this->model[ 'git.syncs' ]))->transform(function ($value) {
                return new GitSyncConfig($this, $value);
            });
        }
        return $this->syncs;
    }

    public function isEnabled()
    {
        return $this->get('enabled', false) === true;
    }

    public function has($keys)
    {
        return isset($this->model[ 'git.' . $keys ]);
    }

    public function get($key, $default = null)
    {
        return $this->model->attr('git.' . $key, $default);
    }

    public function set($key, $value, $overwrite = true)
    {
        if ($overwrite || ! $this->has($key)) {
            $this->model->set('git.' . $key, $value);
        }
        return $this;
    }

    public function unset($key)
    {
        $this->model->offsetUnset('git.' . $key);
        return $this;
    }

    public function toArray()
    {
        $data                       = $this->model->attr('git',[]);
        $data[ 'remotes' ]          = $this->getRemotes()->toArray();
        $data[ 'syncs' ]            = $this->getSyncs()->toArray();
        $data[ 'links' ][ 'links' ] = $this->getLinks()->toArray();
        return $data;
    }

}
