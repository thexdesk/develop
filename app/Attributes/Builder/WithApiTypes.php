<?php


namespace App\Attributes\Builder;


/**
 * This is the WithApiTypes trait.
 *
 * @package App\Attributes\Builder
 * @author  Robin Radic
 */
trait WithApiTypes
{
    public function getName()
    {
        return $this->name;
    }
    public function getDefaultApiType()
    {
        return 'Mixed';
    }

    public function getApiType()
    {
        return array_get($this->attributes, 'api:type', $this->getDefaultApiType());
    }

    public function getApiExtend()
    {
        return array_get($this->attributes, 'api:extend', false);
    }

    public function getApiNew()
    {
        return array_get($this->attributes, 'api:new', false);
    }

    public function setApiType(string $type)
    {
        $this->setApiTypeDefinition($type);
        return $this;
    }

    public function setApiTypeDefinition(string $type, bool $extend = false, bool $new = false)
    {
        $this->attribute('api:type', $type);
        $this->attribute('api:extend', $extend);
        $this->attribute('api:new', $new);
        return $this;
    }
}
