<?php

namespace App\Attributes\Schema;

class Type
{
    /** @var string */
    public $name;

    /** @var bool */
    public $extend = false;

    /** @var bool */
    public $new = false;

    /** @var \Illuminate\Support\Collection|Field[] */
    public $fields;

    /**
     * Type constructor.
     *
     * @param      $name
     * @param bool $extend
     * @param bool $new
     */
    public function __construct(string $name, bool $extend = false, bool $new = false)
    {
        $this->name   = $name;
        $this->extend = $extend;
        $this->new    = $new;
        $this->fields = collect();
    }


    public function addField(Field $field)
    {
        $this->fields->put($field->name, $field);
        return $this;
    }

    public function getField(string $name)
    {
        $this->fields->get($name);
    }

    public function getFields()
    {
        return $this->fields;
    }


    public function toString()
    {
        if ( ! $this->new && ! $this->extend) {
            return $this->name;
        }
        $name   = ($this->extend ? 'extend ' : '') . 'type ' . $this->name;
        $fields = $this->fields->map(function (Field $field) {
            return $field->toString();
        })->implode("\n");
        return "{$name} { \n {$fields} \n }";
    }

    public function __toString()
    {
        return $this->toString();
    }
}
