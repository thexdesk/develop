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

namespace Codex\Phpdoc\Serializer\Phpdoc\Types;

use MyCLabs\Enum\Enum;

/**
 * This is the class EntityType.
 *
 * @author  Robin Radic
 *
 * @method static FileEntityType CLASSES()
 * @method static FileEntityType INTERFACES()
 * @method static FileEntityType TRAITS()
 * @method static FileEntityType GENERICS()
 */
class FileEntityType extends Enum
{
    const CLASSES = 'class';
    const INTERFACES = 'interface';
    const TRAITS = 'trait';
    const GENERICS = 'generic';
}
