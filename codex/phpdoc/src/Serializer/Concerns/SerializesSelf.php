<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc\Serializer\Concerns;

trait SerializesSelf
{
    /**
     * toArray method.
     *
     * @return array|mixed
     */
    public function toArray()
    {
        return static::getSerializer()->toArray($this);
    }

    /**
     * serialize method.
     *
     * @param string $format
     *
     * @return mixed|string
     */
    public function serialize($format = 'json')
    {
        return static::getSerializer()->serialize($this, $format);
    }

    public function toJson(): string
    {
        return $this->serialize('json');
    }

    public function toXml(): string
    {
        return $this->serialize('xml');
    }

    public function toYaml(): string
    {
        return $this->serialize('yml');
    }



    public function offsetExists($offset)
    {
        return method_exists($this, camel_case('get_' . $offset)) || property_exists($this, $offset);
    }

    public function offsetGet($offset)
    {
        if (method_exists($this, $methodName = camel_case('get_' . $offset))) {
            return $this->$methodName();
        }
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * fromArray method.
     *
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        return static::getSerializer()->fromArray($data, static::class);
    }

    /**
     * deserialize method.
     *
     * @param        $data
     * @param string $format
     *
     * @return static
     */
    public static function deserialize($data, $format = 'xml')
    {
        return static::getSerializer()->deserialize($data, static::class, $format);
    }

    /**
     * getSerializer method.
     *
     * @return \JMS\Serializer\Serializer
     */
    protected static function getSerializer()
    {
        return app(\JMS\Serializer\Serializer::class);
    }
}
