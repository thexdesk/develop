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

namespace Codex\Git\Support;

use vierbergenlars\SemVer\SemVerException;

class Version extends \vierbergenlars\SemVer\version
{
    /**
     * create method.
     *
     * @param      $string
     * @param bool $loose
     *
     * @return bool|static
     */
    public static function create($string, $loose = false)
    {
        try {
            return new static($string, $loose);
        } catch (SemVerException $e) {
            return false;
        }
    }

    /**
     * isValid method.
     *
     * @param $string
     *
     * @return bool
     */
    public static function isValid($string)
    {
        return false !== static::create($string);
    }
}
