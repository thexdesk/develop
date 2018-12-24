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

namespace Codex\Phpdoc\Serializer\Phpdoc\File;

use Codex\Phpdoc\Serializer\Phpdoc\Properties\FileEntityElement;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\NamedSpacedElement;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class TraitFile.
 *
 * @author  Robin Radic
 *
 * @Serializer\XmlRoot("trait")
 */
class TraitFile
{
    use SerializesSelf,
        NamedSpacedElement,
        FileEntityElement;
}
