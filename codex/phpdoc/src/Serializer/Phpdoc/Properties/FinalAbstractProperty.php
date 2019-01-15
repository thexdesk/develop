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

namespace Codex\Phpdoc\Serializer\Phpdoc\Properties;

use Codex\Phpdoc\Serializer\Annotations\Attr;
use JMS\Serializer\Annotation as Serializer;

trait FinalAbstractProperty
{
    /**
     * @var bool
     * @Serializer\Type("boolean")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $final;

    /**
     * @var bool
     * @Serializer\Type("boolean")
     * @Serializer\XmlAttribute()
     * @Attr()
     */
    private $abstract;

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->final;
    }

    /**
     * Set the final value.
     *
     * @param bool $final
     *
     * @return FinalAbstractProperty
     */
    public function setFinal($final)
    {
        $this->final = $final;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * Set the abstract value.
     *
     * @param bool $abstract
     *
     * @return FinalAbstractProperty
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }
}
