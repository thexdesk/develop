<?php

namespace App\Attributes\Schema;

class Field
{
    /** @var string */
    public $name;

    /** @var Type */
    public $type;

    /** @var bool  */
    public $nonNull = false;

    /**
     * Field constructor.
     *
     * @param string                      $name
     * @param \App\Attributes\Schema\Type $type
     * @param bool                        $nonNull
     */
    public function __construct(string $name, Type $type, bool $nonNull = false)
    {
        $this->name    = $name;
        $this->type    = $type;
        $this->nonNull = $nonNull;
    }


    public function toString()
    {
        return implode(' ', [$this->name, ':', (string) $this->type, $this->nonNull ? '!' : '']);
    }

    public function __toString()
    {
        return $this->toString();
    }
}
