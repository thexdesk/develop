<?php


namespace Codex\Git\Config;


class GitSyncConfig extends AbstractGitConfigChild
{
    public function getRemote()
    {
        return $this->getGit()->getRemotes()->get($this->get('remote'));
    }
}
