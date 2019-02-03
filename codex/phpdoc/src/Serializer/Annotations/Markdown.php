<?php

namespace Codex\Phpdoc\Serializer\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;
/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Markdown
{
    /** @var bool */
    private $parse = true;
}
