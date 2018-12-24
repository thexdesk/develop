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

namespace Codex\Phpdoc\Http\Controllers\Api\V1;

use Codex\Phpdoc\Contracts\PhpdocRevision;
use Codex\Phpdoc\Http\Responses;
use Codex\Codex;
use Illuminate\Routing\Controller;

class CodexPhpdocApiController extends Controller
{
    /** @var \Codex\Codex */
    protected $codex;

    /**
     * CodexPhpdocApiController constructor.
     *
     * @param \Codex\Codex                          $codex
     * @param \Codex\Phpdoc\Contracts\Factory $factory
     */
    public function __construct(Codex $codex)
    {
        $this->codex = $codex;
    }

    public function getProject(string $project)
    {
        return new Responses\PhpdocProjectResponse(
            $this->codex->getProject($project)
        );
    }

    public function getFull(string $project, string $revision)
    {
        return $this->getRevision($project, $revision)->getFull();
    }

    public function getManifest(string $project, string $revision)
    {
        return new Responses\PhpdocManifestResponse(
            $this->getRevision($project, $revision)
        );
    }

    public function getFile(string $project, string $revision, string $hash)
    {
        return new Responses\PhpdocFileResponse(
            $this->getRevision($project, $revision),
            $hash
        );
    }

    protected function getRevision(string $project, string $revision): PhpdocRevision
    {
        return $this->codex->getProject($project)->getRevision($revision)->phpdoc->generate(false);
    }
}
