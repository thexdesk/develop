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

class PhpdocFileResponse extends ApiResponse
{
    /** @var \Codex\Phpdoc\Contracts\PhpdocRevision */
    protected $registry;

    /** @var string */
    private $hash;

    /**
     * PhpdocFileResponse constructor.
     *
     * @param \Codex\Phpdoc\Contracts\PhpdocRevision $registry
     */
    public function __construct(PhpdocRevision $registry, string $hash)
    {
        $this->registry = $registry;
        $this->hash = $hash;
    }

    /**
     * transform method.
     *
     * @return array
     */
    public function transform()
    {
        $file = $this->registry->getFile($this->hash);
        $this->transforming('phpdoc:file', $file);

        return $this->transformed($file->toArray());
    }
}
