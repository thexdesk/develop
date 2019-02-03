<?php

namespace Codex\Phpdoc\Http\Controllers;

use Illuminate\Routing\Controller;

class PhpdocController extends Controller
{

    public function getRevisionPhpdoc($projectKey = null, $revisionKey = null)
    {
        $codex = codex();

        if (null === $projectKey) {
            return redirect($codex->url($codex->getProjects()->getDefaultKey()));
        }
        abort_if(! $codex->hasProject($projectKey), 404);

        $project = $codex->getProject($projectKey);

        if (null === $revisionKey) {
            return redirect($codex->url($projectKey, $project->getRevisions()->getDefaultKey()));
        }
        abort_if(! $project->hasRevision($revisionKey), 404);

        $revision = $project->getRevision($revisionKey);
        $phpdoc   = $revision->phpdoc();

        abort_if(! $phpdoc->isEnabled() || ! $phpdoc->isGenerated(), 404);


        view()->share(compact('codex', 'project', 'revision', 'phpdoc'));

        return view($revision->attr('phpdoc.view'), compact('phpdoc'));
    }
}
