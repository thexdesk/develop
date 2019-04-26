<?php


namespace Codex\Git\Config;


use Codex\Git\Drivers\DriverInterface;

class GitRemoteConfig extends AbstractGitConfigChild
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

    /**
     * @return \Codex\Git\Drivers\DriverInterface
     */
    public function getConnection()
    {
        return $this->getGit()->getManager()->connection($this->get('connection'));
    }

    public function getConnectionConfig()
    {
        return $this->getGit()->getManager()->getConnectionConfig($this->get('connection'));
    }

    public function getOwner():string
    {
        return $this->get('owner');
    }
    public function getRepository():string
    {
        return $this->get('repository');
    }

    public function isWebhookEnabled()
    {
        return $this->get('webhook.enabled', false) === true;
    }

    public function getWebhookSecret()
    {
        return $this->get('webhook.secret');
    }

    public function getRefs()
    {
        return $this->getConnection()->getRefs($this->getOwner(), $this->getRepository());
    }
}
