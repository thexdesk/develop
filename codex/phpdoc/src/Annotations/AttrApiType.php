<?php

namespace Codex\Phpdoc\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 */
class AttrApiType
{
    /**
     * @var string
     * @Required()
     */
    public $name;

    /** @var bool */
    public $extend = false;

    /** @var bool */
    public $array = false;

    /** @var bool */
    public $new = false;

    /** @var bool */
    public $nonNull = false;

    /** @var bool */
    public $arrayNonNull = false;
}
