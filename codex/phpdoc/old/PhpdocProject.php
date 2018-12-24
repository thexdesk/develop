<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc;

use Codex\Contracts\Project;
use Codex\Support\Extendable;

class PhpdocProject extends Extendable
{
    /** @var \Codex\Contracts\Project|\Codex\Project */
    protected $project;

    /**
     * PhpdocProject constructor.
     *
     * @param \Codex\Contracts\Project $parent
     */
    public function __construct(Project $parent)
    {
        $this->project = $parent;
    }

    /**
     * isEnabled method.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return true === $this->project->config('phpdoc.enabled', false);
    }

    /**
     * getRevisions method.
     *
     * @return \Codex\Phpdoc\Contracts\PhpdocRevision[]
     */
    public function getRevisions(): array
    {
        if (false === $this->isEnabled()) {
            return [];
        }
        // filter out all non-phpdoc revisions, then get all of the phpdoc-enabled revisions PhpdocRevision
        $revs = $this->project
            ->getRevisions()
            ->toLaravelCollection()
            ->filter(function (array $revision) {
                return isset($revision['phpdoc']['enabled']) && true === $revision['phpdoc']['enabled'];
            });

        return $revs->transform(function (array $revision) {
            return $this->project->getRevision($revision['key'])->phpdoc;
        })->toArray();
    }
}
