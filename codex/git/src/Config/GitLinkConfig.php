<?php


namespace Codex\Git\Config;


class GitLinkConfig extends AbstractGitConfigChild
{

    /** @var string */
    protected $name;

    public function __construct(GitConfig $git, array $data, string $name)
    {
        parent::__construct($git, $data);
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRemote()
    {
        return $this->getGit()->getRemotes()->get($this->get('remote'));
    }
}
