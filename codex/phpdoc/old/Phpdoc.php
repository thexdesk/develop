<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author    Robin Radic
 * @license   https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc;

class Phpdoc implements Contracts\Phpdoc
{
    public function getRoutePath()
    {
        return str_ensure_left(config('codex.http.base_route'), str_ensure_left(config('codex-phpdoc.route_path', 'phpdoc'), '/'), '/');
    }

    public function makeEntity($fullName)
    {
        return new Entity($fullName);
    }

    public function url(string $project, string $revision)
    {
        route('');
    }
}
