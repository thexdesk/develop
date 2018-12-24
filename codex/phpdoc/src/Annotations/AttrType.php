<?php

namespace Codex\Phpdoc\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 */
final class AttrType
{
    /**
     * @var string
     * @Required()
     */
    private $name;

}
