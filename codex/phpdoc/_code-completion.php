<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2017 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */


namespace Codex {


    /**
     * This is the class Project.
     *
     * @package Codex
     * @author  Robin Radic
     *
     *
     * @ property-read \Codex\Addon\Phpdoc\Contracts\PhpdocProject $phpdoc2
     * @property-read \Codex\Addon\Phpdoc\Contracts\Phpdoc|\Codex\Addon\Phpdoc\Phpdoc$phpdoc
     */
    class Codex
    {
        /** @var \Codex\Addon\Phpdoc\Contracts\Phpdoc|\Codex\Addon\Phpdoc\Phpdoc */
        public $phpdoc;
    }
    /**
     * This is the class Project.
     *
     * @package Codex
     * @author  Robin Radic
     *
     *
     * @ property-read \Codex\Addon\Phpdoc\Contracts\PhpdocProject $phpdoc2
     * @property-read \Codex\Addon\Phpdoc\Contracts\PhpdocProject|\Codex\Addon\Phpdoc\PhpdocProject $phpdoc
     */
    class Project
    {
        /** @var \Codex\Addon\Phpdoc\Contracts\PhpdocProject|\Codex\Addon\Phpdoc\PhpdocProject */
        public $phpdoc;
    }

    /**
     * This is the class Revision.
     *
     * @package Codex
     * @author  Robin Radic
     *
     * @ property-read \Codex\Addon\Phpdoc\Contracts\PhpdocRevision $phpdoc2
     * @ property-read \Codex\Addon\Phpdoc\Contracts\PhpdocRevision $phpdoc
     */
    class Revision
    {
        /** @var \Codex\Addon\Phpdoc\Contracts\PhpdocRevision|\Codex\Addon\Phpdoc\PhpdocRevision */
        public $phpdoc;
    }
}

namespace Codex\Contracts {

    /**
     * Interface Project
     *
     * @package Codex\Contracts
     * @author  Robin Radic
     */
    interface Project
    {

    }

    /**
     * Interface Revision
     *
     * @package Codex\Contracts
     * @author  Robin Radic
     */
    interface Revision
    {

    }
}
