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
 * This is the class AccessModifier.
 *
 * @author  Robin Radic
 *
 * @method static AccessModifier PUBLIC()
 * @method static AccessModifier PROTECTED()
 * @method static AccessModifier PRIVATE()
 */
class AccessModifier extends Enum
{
    const PUBLIC = 'public';
    const PROTECTED = 'protected';
    const PRIVATE = 'private';
}
