<?php

namespace Codex\Phpdoc\Annotations;

use Doctrine\Common\Annotations\Annotation\IgnoreAnnotation;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
final class Attr
{
    /** @var string */
    private $name;

    /**
     * @var string
     * @Required()
     */
    private $type;
}
