<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author    Robin Radic
 * @license   https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc\Serializer\Phpdoc\File;

use Codex\Phpdoc\Serializer\Annotations\Attr;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class NamespaceAlias.
 *
 * @author  Robin Radic
 *
 * @Serializer\XmlRoot("namespace-alias")
 */
class NamespaceAlias
{
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $name;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlValue(cdata=false)
     * @Attr()
     */
    private $value;
}
