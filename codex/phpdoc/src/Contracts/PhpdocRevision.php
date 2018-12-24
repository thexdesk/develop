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

use Codex\Phpdoc\Serializer\Manifest;
use Codex\Phpdoc\Serializer\Phpdoc\File;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Codex\Contracts\Revision;

interface PhpdocRevision
{
    public function generate($queue = true, $force = false): self;

    public function getManifest(): Manifest;

    public function getFull(): PhpdocStructure;

    public function getFile(string $hash): File;

    public function getFileByFullName(string $fullName): File;

    public function getRevision(): Revision;

    public function getProject(): PhpdocProject;

    public function getDestinationPath(): string;
}
