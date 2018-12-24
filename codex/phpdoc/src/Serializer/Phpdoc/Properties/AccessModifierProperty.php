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

namespace Codex\Phpdoc\Serializer\Phpdoc\Properties;

use Codex\Phpdoc\Serializer\Phpdoc\Types\AccessModifier;
use JMS\Serializer\Annotation as Serializer;

trait AccessModifierProperty
{
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute()
     */
    private $visibility = 'public';

    /**
     * @return AccessModifier
     *
     * @throws \UnexpectedValueException
     */
    public function getVisibility(): AccessModifier
    {
        return new AccessModifier($this->visibility);
    }

    /**
     * Set the visibilty value.
     *
     * @param AccessModifier $visibility
     *
     * @return static
     */
    public function setVisibility(AccessModifier $visibility): self
    {
        $this->visibility = $visibility->getValue();

        return $this;
    }
}
