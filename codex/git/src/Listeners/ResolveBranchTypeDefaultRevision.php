<?php

namespace Codex\Git\Listeners;

use Codex\Git\BranchType;
use Codex\Projects\Events\ResolvedProject;

class ResolveBranchTypeDefaultRevision
{
    public function handle(ResolvedProject $event)
    {
        $project         = $event->getProject();
        $defaultRevision = $project[ 'revision.default' ];
        if ($defaultRevision === BranchType::LAST_VERSION) {
            $project[ 'revision.default' ] = $project->getRevisions()->getLatestVersion();
        } elseif ($defaultRevision === BranchType::PRODUCTION) {
            $project[ 'revision.default' ] = $project[ 'branching.production' ];
        } elseif ($defaultRevision === BranchType::DEVELOPMENT) {
            $project[ 'revision.default' ] = $project[ 'branching.development' ];
        }
    }
}
