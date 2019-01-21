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

namespace Codex\Phpdoc\Contracts\Serializer;

use Illuminate\Contracts\Support\Arrayable;

interface SelfSerializable extends Arrayable, \ArrayAccess
{

    /**
     * serialize method.
     *
     * @param string $format
     *
     * @return mixed|string
     */
    public function serialize($format = 'json');

    /**
     * toJson method.
     *
     * @return string
     */
    public function toJson(): string;

    /**
     * toXml method.
     *
     * @return string
     */
    public function toXml(): string;

    /**
     * toYaml method.
     *
     * @return string
     */
    public function toYaml(): string;

    /**
     * fromArray method.
     *
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data);

    /**
     * deserialize method.
     *
     * @param        $data
     * @param string $format
     *
     * @return static
     */
    public static function deserialize($data, $format = 'xml');
}
