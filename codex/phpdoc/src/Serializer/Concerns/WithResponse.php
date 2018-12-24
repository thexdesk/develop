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

namespace Codex\Phpdoc\Serializer\Concerns;

use BadMethodCallException;

trait WithResponse
{

    /**
     * toResponse method.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse void
     *
     * @throws \BadMethodCallException
     */
    public function toResponse($request)
    {
        if (false === method_exists($this, 'toArray')) {
            $class = static::class;
            throw new BadMethodCallException("Could not call toArray on [{$class}]. Did you forget to apply the SerializesSelf trait?");
        }

        if (method_exists($this, 'transformToResponse')) {
            $data = $this->transformToResponse();
        } else {
            $data = $this->toArray();
        }

        return response()->json($data);
    }
}
