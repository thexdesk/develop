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

namespace Codex\Phpdoc;

use Codex\Contracts\Revision;
use Illuminate\Contracts\Container\Container;

class Factory implements Contracts\Factory
{
    /** @var \Codex\Phpdoc\PhpdocRevision[] */
    protected $revisions = [];

    /** @var \Illuminate\Contracts\Container\Container */
    protected $container;

    /**
     * PhpdocFactory constructor.
     *
     * @param \Codex\Phpdoc\PhpdocRevision[]      $revisions
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function revision(Revision $revision): PhpdocRevision
    {
        $key = $revision->getProject()->getKey().'.'.$revision->getKey();
        if (false === array_has($this->revisions, $key)) {
            $revisionDoc = $this->container->make(PhpdocRevision::class, compact('revision'));
            array_set($this->revisions, $key, $revisionDoc);

            return $revisionDoc;
        }

        return array_get($this->revisions, $key);
    }
}
