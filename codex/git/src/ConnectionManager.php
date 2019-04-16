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

namespace Codex\Git;

use Codex\Git\Drivers\DriverInterface;
use GrahamCampbell\Manager\AbstractManager;

/**
 * This is the class ConnectionManager.
 *
 * @author  Robin Radic
 * @mixin \Codex\Git\Drivers\GithubDriver
 * @method DriverInterface connection(string $name = null)
 */
class ConnectionManager extends AbstractManager implements Contracts\ConnectionManager
{
    protected function createConnection(array $config)
    {
        $a = 'a';
    }

    protected function getConfigName()
    {
        return 'codex-git';
    }
}
