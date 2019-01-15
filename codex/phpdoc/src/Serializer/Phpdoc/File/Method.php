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
use Codex\Phpdoc\Serializer\Phpdoc\Properties\AccessModifierProperty;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\FinalAbstractProperty;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\InheritedProperty;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\NamedSpacedElement;
use Codex\Phpdoc\Serializer\Phpdoc\Properties\StaticProperty;
use JMS\Serializer\Annotation as Serializer;

/**
 * This is the class Method.
 *
 * @author  Robin Radic
 *
 * @Serializer\XmlRoot("method")
 */
class Method
{
    use NamedSpacedElement,
        FinalAbstractProperty,
        AccessModifierProperty,
        InheritedProperty,
        StaticProperty;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\Argument[]
     * @Serializer\Type("array<Codex\Phpdoc\Serializer\Phpdoc\File\Argument>")
     * @Serializer\XmlList(inline=true,entry="argument")
     * @Serializer\SerializedName("argument")
     * @Attr(new=true, array=true)
     */
    private $arguments;

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\Argument[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Set the arguments value.
     *
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\Argument[] $arguments
     *
     * @return Method
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    public function getReturns()
    {
        if ( ! $this->getDocblock()->hasTag('return')) {
            return 'void';
        }

        return $this->getDocblock()->getTag('return');
    }
}
