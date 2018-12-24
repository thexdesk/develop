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

namespace Codex\Git;

use Codex\Contracts\Projects\Project;
use Codex\Git\Connection\Ref;
use vierbergenlars\SemVer\expression;

class ProjectGitConfig
{
    /** @var \Codex\Contracts\Projects\Project */
    protected $project;

    /** @var expression */
    protected $versions;

    /** @var \Codex\Git\Contracts\ConnectionManager */
    protected $manager;

    /**
     * ProjectGitConfig constructor.
     *
     * @param \Codex\Contracts\Projects\Project      $parent
     * @param \Codex\Git\Contracts\ConnectionManager $manager
     */
    public function __construct(Project $parent, Contracts\ConnectionManager $manager)
    {
        $this->project = $parent;
        $this->manager = $manager;
    }

    /**
     * isEnabled method.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return true === $this->project[ 'git.enabled' ];
    }

    public function shouldSyncRef(Ref $ref)
    {
        if ($ref->isBranch()) {
            return \in_array($ref->getName(), $this->getBranches(), true);
        }
        if ($ref->isTag()) {
            $version = $ref->getVersion();
            if ($this->getVersions()->satisfiedBy($version)) {
                return true;
            }
        }

        return false;
    }

    public function getOwner()
    {
        return $this->project['git.owner'];
    }

    public function getRepository()
    {
        return $this->project['git.repository'];
    }

    /**
     * getConnection method.
     *
     * @return \Codex\Git\Drivers\DriverInterface|mixed
     */
    public function getConnection()
    {
        return $this->manager->connection($this->project['git.connection']);
    }

    public function getBranches()
    {
        return $this->project['git.branches'];
    }

    public function getVersions()
    {
        if (null === $this->versions) {
            $this->versions = new expression($this->project['git.versions']);
        }

        return $this->versions;
    }

    public function skipsPatchVersions()
    {
        return $this->project['git.skip.patch_versions'];
    }

    public function skipsMinorVersions()
    {
        return $this->project['git.skip.minor_versions'];
    }

    public function getDocsPath()
    {
        return $this->project['git.paths.docs'];
    }

    public function getIndexPath()
    {
        return $this->project['git.paths.index'];
    }

    /**
     * getProject method
     *
     * @return \Codex\Contracts\Projects\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * getManager method
     *
     * @return \Codex\Git\Contracts\ConnectionManager
     */
    public function getManager()
    {
        return $this->manager;
    }
}
