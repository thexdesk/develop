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

namespace Codex\Phpdoc\Commands;

use Codex\Phpdoc\Contracts\Generator as GeneratorContract;
use Codex\Phpdoc\Generator;
use Codex\Contracts\Revision;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GenerateRevisionPhpdoc implements ShouldQueue
{
//    use DispatchesJobs {
//        dispatch as _dispatch;
//        dispatchNow as _dispatchNow;
//    }

    /** @var string */
    protected $revision;

    /** @var string */
    protected $project;

    /** @var int */
    protected $flags;

    /**
     * GenerateRevisionPhpdoc constructor.
     *
     * @param \Codex\Contracts\Revision $revision
     * @param int                       $flags
     */
    public function __construct(Revision $revision, $flags = Generator::FLAG_MANIFEST | Generator::FLAG_FILES | Generator::FLAG_PROJECT)
    {
        $this->revision = $revision->getKey();
        $this->project = $revision->getProject()->getKey();
        $this->flags = $flags;
    }

    public function handle()
    {
        $revision = codex()->getProject($this->project)->getRevision($this->revision);
        $xmlPath = $revision->path($revision->config('phpdoc.xml_path', 'structure.xml'));
        $destinationPath = path_join(config('codex-phpdoc.storage.path'), $revision->getProject()->getKey(), $revision->getKey());
        $revision = codex()->getProject($this->project)->getRevision($this->revision);

        return app(GeneratorContract::class)
            ->setRevision($revision)
            ->setDestinationPath($destinationPath)
            ->setXmlLastModified($revision->getFiles()->lastModified($xmlPath))
            ->setXml($revision->getFiles()->get($xmlPath))
            ->generate($this->flags);
    }

//    public function dispatch($queue = true, $flags = 0)
//    {
//        if ($queue) {
//            $this->_dispatch($this);
//        } else {
//            $this->_dispatchNow($this);
//        }
//    }
}
