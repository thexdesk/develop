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
class Method  implements SelfSerializable
{
    use SerializesSelf,
        NamedSpacedElement,
        FinalAbstractProperty,
        AccessModifierProperty,
        InheritedProperty,
        StaticProperty;

    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\Argument[]
     * @Serializer\Type("LaravelCollection<Codex\Phpdoc\Serializer\Phpdoc\File\Argument>")
     * @Serializer\XmlList(inline=true,entry="argument")
     * @Attr(new=true, array=true)
     */
    private $arguments;

    /**
     * @var string[]
     * @Serializer\Type("array<string>")
     * @Serializer\Accessor(getter="getReturns")
     * @Attr(type="string", array=true)
     */
    private $returns;

    /**
     * @Serializer\PostDeserialize()
     */
    public function postDeserialize()
    {
        $tags = $this->getDocblock()->getTags();
        foreach ($this->getArguments() as $i => $argument) {
            /** @var Tag $tag */
            $tag = $tags->where('name', 'param')->where('variable', $argument->getName())->first();
            if ($tag) {
                $argument->setType($tag->getType());
            }
        }
    }

    /**
     * @return \Codex\Phpdoc\Serializer\Handler\LaravelCollection|\Codex\Phpdoc\Serializer\Phpdoc\File\Argument[]
     */
    public function getArguments()
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
            return [ 'void' ];
        }

        return $this->getDocblock()->getTag('return')->getTypes();
    }
}
