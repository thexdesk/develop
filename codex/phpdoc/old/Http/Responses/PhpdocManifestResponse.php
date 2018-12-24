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

use Codex\Phpdoc\Contracts\PhpdocRevision;
use Codex\Http\Responses\ApiResponse;

class PhpdocManifestResponse extends ApiResponse
{
    /** @var \Codex\Phpdoc\PhpdocRevision|\Codex\Phpdoc\Contracts\PhpdocRevision */
    protected $revision;

    /**
     * PhpdocFileResponse constructor.
     *
     * @param \Codex\Phpdoc\Contracts\PhpdocRevision $registry
     */
    public function __construct(PhpdocRevision $registry)
    {
        $this->revision = $registry;
    }

    /**
     * transform method.
     *
     * @return array
     */
    public function transform()
    {
        $manifest = $this->revision->getManifest();
        $this->transforming('phpdoc:manifest', $manifest);

        return $this->transformed($manifest->toArray());
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
