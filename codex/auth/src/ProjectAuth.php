<?php

namespace Codex\Auth;

class ProjectAuth
{
    /** @var \Codex\Contracts\Projects\Project */
    protected $project;

    public function __construct(\Codex\Contracts\Projects\Project $project)
    {
        $this->project = $project;
    }


    public function isEnabled()
    {
        return $this->project->attr('auth.enabled', false);
    }

    public function hasAccess()
    {
        if ( ! $this->isEnabled()) {
            return true;
        }
        return $this->project->getCodex()->auth()->hasAccess($this->project);
    }
}
