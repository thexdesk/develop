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

use Codex\Contracts\Documents\Document;
use Codex\Git\Connection\Ref;
use Codex\Models\Model;
use vierbergenlars\SemVer\expression;

class GitConfig
{
    /** @var \Codex\Contracts\Projects\Project|\Codex\Contracts\Revisions\Revision|\Codex\Contracts\Documents\Document */
    protected $model;

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
    public function __construct(Model $parent, Contracts\ConnectionManager $manager)
    {
        $this->model   = $parent;
        $this->manager = $manager;
    }

    /**
     * isEnabled method.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return true === $this->model[ 'git.enabled' ];
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
        return $this->model[ 'git.owner' ];
    }

    public function getRepository()
    {
        return $this->model[ 'git.repository' ];
    }

    /**
     * @return \Codex\Git\Drivers\DriverInterface|mixed
     */
    public function connect()
    {
        return $this->manager->connection($this->model[ 'git.connection' ]);
    }

    /**
     * The connection name
     *
     * @return string
     */
    public function getConnection()
    {
        return $this->model[ 'git.connection' ];
    }

    public function getUrl()
    {
        return $this->connect()->getUrl($this->getOwner(), $this->getRepository());
    }

    /**
     * @param \Codex\Contracts\Documents\Document|string $document
     *
     * @return string
     */
    public function getDocumentUrl($document)
    {
        if ($document instanceof Document) {
            $document = $document->getPath();
        }
        return $this->connect()->getDocumentUrl($this->getOwner(), $this->getRepository(), path_join($this->getDocsPath(), (string)$document));
    }

    public function getBranches()
    {
        return $this->model[ 'git.branches' ];
    }

    public function getVersions()
    {
        if (null === $this->versions) {
            $this->versions = new expression($this->model[ 'git.versions' ]);
        }

        return $this->versions;
    }

    public function skipsPatchVersions()
    {
        return $this->model[ 'git.skip.patch_versions' ];
    }

    public function skipsMinorVersions()
    {
        return $this->model[ 'git.skip.minor_versions' ];
    }

    public function getDocsPath()
    {
        return $this->model[ 'git.paths.docs' ];
    }

    public function getIndexPath()
    {
        return $this->model[ 'git.paths.index' ];
    }

    /**
     * getProject method
     *
     * @return \Codex\Contracts\Projects\Project
     */
    public function getModel()
    {
        return $this->model;
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
