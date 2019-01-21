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

use Codex\Phpdoc\Contracts\Serializer\SelfSerializable;
use Codex\Phpdoc\Serializer\Annotations\Attr;
use Codex\Phpdoc\Serializer\Concerns\SerializesSelf;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\TypeProperty;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class Argument.
 *
 * @Serializer\XmlRoot("argument")
 */
class Argument implements SelfSerializable
{
    use SerializesSelf;
    use TypeProperty;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlElement()
     * @Attr()
     */
    private $name;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlElement()
     * @Serializer\Accessor(setter="setDefault")
     * @Attr()
     */
    private $default;

    /**
     * @var boolean
     * @Serializer\Type("boolean")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $by_reference = false;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDefault(): string
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        if ($default === '') {
            $default = null;
        }
        if ($default === "''") {
            $default = '""';
        }
        $this->default = $default;
    }

    /**
     * @return bool
     */
    public function isByReference(): bool
    {
        return $this->by_reference;
    }


}
