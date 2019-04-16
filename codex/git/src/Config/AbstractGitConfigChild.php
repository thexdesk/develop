<?php


namespace Codex\Git\Config;


use ArrayAccess;
use Codex\Support\HasDotArray;
use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractGitConfigChild implements ArrayAccess, Arrayable
{
    use HasDotArray;

    /** @var \Codex\Git\Config\GitConfig */
    protected $git;

    public function __construct(GitConfig $git, array $data)
    {
        $this->git   = $git;
        $this->items = $data;
    }

    public function getGit()
    {
        return $this->git;
    }
}
