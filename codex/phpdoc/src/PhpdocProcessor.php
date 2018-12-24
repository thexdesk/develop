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

use Codex\Addons\Annotations as CA;
use Codex\Document;

/**
 * This is the class PhpdocProcessor.
 *
 * @author  Robin Radic
 *
 * @CA\Processor("phpdoc",  after={"parser"})
 */
class PhpdocProcessor
{
    public function handle(Document $document)
    {
        if (!$document->getRevision()->phpdoc->isEnabled()) {
            return;
        }
//        if ($document->getRevision()->config('phpdoc.enabled', false) !== true) {
        $content = $document->getContent();
        $document->setContent("<phpdoc-content project='{$document->getProject()}' revision='{$document->getRevision()}'>{$content}</phpdoc-content>");
    }
}
