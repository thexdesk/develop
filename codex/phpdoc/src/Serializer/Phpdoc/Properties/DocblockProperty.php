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

use Codex\Phpdoc\Annotations\Attr;
use JMS\Serializer\Annotation as Serializer;

trait DocblockProperty
{
    /**
     * @var \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock
     * @Serializer\Type("Codex\Phpdoc\Serializer\Phpdoc\File\Docblock")
     * @Serializer\XmlElement(cdata=false)
     * @Attr(new=true)
     */
    private $docblock;

    /**
     * @return \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock
     */
    public function getDocblock(): \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock
    {
        return $this->docblock;
    }

    /**
     * @param \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock $docblock
     *
     * @return DocblockProperty
     */
    public function setDocblock(\Codex\Phpdoc\Serializer\Phpdoc\File\Docblock $docblock): DocblockProperty
    {
        $this->docblock = $docblock;

        return $this;
    }
}
