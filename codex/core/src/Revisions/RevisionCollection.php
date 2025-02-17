<?php

namespace Codex\Revisions;

use Codex\Models\ModelCollection;
use Codex\Revisions\Commands\FindRevisions;
use Codex\Revisions\Commands\ResolveRevision;

/**
 * This is the class RevisionCollection.
 *
 * @package Codex\Projects
 * @author  Robin Radic
 * @method \Codex\Contracts\Revisions\Revision get($key);
 * @method \Codex\Contracts\Projects\Project getParent();
 */
class RevisionCollection extends ModelCollection
{
    /**
     * getProject method
     *
     * @return \Codex\Contracts\Projects\Project
     */
    public function getProject()
    {
        return $this->getParent();
    }

    /**
     * resolveModels method
     *
     * @return array
     */
    protected function resolveLoadable()
    {
        return $this->dispatch(new FindRevisions($this->getProject()));
    }

    /**
     * resolveModels method
     *
     * @return \Codex\Contracts\Revisions\Revision
     */
    protected function makeModel($key)
    {
        return $this->dispatch(new ResolveRevision($this->getProject(), $this->getLoadable($key)));
    }

    /**
     * getDefault method
     *
     * @return mixed
     */
    public function getDefaultKey()
    {
        return $this->getProject()->attr('default_revision');
    }
}
