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

use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\AccessModifierProperty;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\InheritedProperty;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\NamedSpacedElement;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\StaticProperty;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\TypeProperty;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class Property.
 *
 * @author  Robin Radic
 *
 * @Serializer\XmlRoot("property")
 */
class Property implements SelfSerializable
{
    use SerializesSelf,
        NamedSpacedElement,
        AccessModifierProperty,
        StaticProperty,
        InheritedProperty,
        TypeProperty;
}
