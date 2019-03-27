<?php

namespace App\Attr;

use MabeEnum\Enum;

/**
 * @method static Type STRING()
 * @method static Type BOOL()
 * @method static Type INT()
 * @method static Type FLOAT()
 * @method static Type ARRAY()
 * @method static Type MIXED()
 */
class Type extends Enum
{
    const STRING = 'string';
    const BOOL = 'bool';
    const INT = 'int';
    const FLOAT = 'float';
    const ARRAY = 'array';
    const MIXED = 'mixed';

    public static $apiTypeMap = [
        self::STRING => 'String',
        self::BOOL   => 'Boolean',
        self::INT    => 'Int',
        self::FLOAT  => 'Int',
        self::ARRAY  => '[Assoc]',
        self::MIXED  => 'Mixed',
    ];

    /**
     * @param Type|string $type
     *
     * @return mixed|string
     */
    public static function getApiType($type)
    {
        if ($type instanceof static) {
            $type = $type->getValue();
        }
        return array_key_exists($type, static::$apiTypeMap) ? static::$apiTypeMap[ $type ] : 'Mixed';
    }

    public function toApiType()
    {
        return static::getApiType($this);
    }
}

