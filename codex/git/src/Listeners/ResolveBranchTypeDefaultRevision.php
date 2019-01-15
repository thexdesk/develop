<?php

namespace Codex\Git\Listeners;

use Codex\Git\BranchType;
use Codex\Projects\Events\ResolvedProject;

class ResolveBranchTypeDefaultRevision
{
    public function handle(ResolvedProject $event)
    {
        $project         = $event->getProject();
        $defaultRevision = $project[ 'default_revision' ];
        if ($defaultRevision === BranchType::LAST_VERSION) {
            $project[ 'default_revision' ] = $project->getRevisions()->getLatestVersion();
        } elseif ($defaultRevision === BranchType::PRODUCTION) {
            $project[ 'default_revision' ] = $project[ 'branching.production' ];
        } elseif ($defaultRevision === BranchType::DEVELOPMENT) {
            $project[ 'default_revision' ] = $project[ 'branching.development' ];
        }
    }
}
