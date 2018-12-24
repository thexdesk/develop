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

use JMS\Serializer\Annotation as Serializer;

trait LineProperty
{
    /**
     * @var int
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute()
     */
    private $line;

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    /**
     * Set the line value.
     *
     * @param int $line
     *
     * @return LineProperty
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }
}
