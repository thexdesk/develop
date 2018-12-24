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

namespace Codex\Phpdoc\Http\Responses;

use Codex\Contracts\Project;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Filesystem\Filesystem;

class PhpdocProjectResponse implements Responsable
{
    /** @var \Codex\Contracts\Project|\Codex\Project */
    protected $project;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    /**
     * PhpdocRevisionResponse constructor.
     *
     * @param \Codex\Revision $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->fs = new Filesystem();
    }

    /**
     * transform method.
     *
     * @return array
     */
    public function transform()
    {
        return $this->project->phpdoc->getRevisions();
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return response()->json($this->transform());
    }
}
