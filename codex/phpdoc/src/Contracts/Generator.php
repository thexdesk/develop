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

namespace Codex\Phpdoc\Contracts;

use Codex\Contracts\Revision;

interface Generator
{
    /**
     * Set the last modified date for the structure.xml file.
     *
     * @param int $xmlLastModified
     *
     * @return static
     */
    public function setXmlLastModified(int $xmlLastModified);

    /**
     * Set the XML string provided by a PHPDoc generated structure.xml file.
     *
     * @param string $xml
     *
     * @return static
     */
    public function setXml(string $xml);

    /**
     * Set the path to the directory to write all files in.
     *
     * @param string $destinationPath
     *
     * @return static
     */
    public function setDestinationPath(string $destinationPath);

    /**
     * Generates the PHPDoc export files.
     *
     * @param int $flags
     *
     * @return mixed
     */
    public function generate($flags = 0);

    /**
     * Checks against the lastModified if generation is needed.
     *
     * @return bool
     */
    public function shouldGenerate();

    /**
     * setRevision method.
     *
     * @param \Codex\Contracts\Revision $revision
     *
     * @return static
     */
    public function setRevision(Revision $revision);
}
