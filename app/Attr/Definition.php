<?php

namespace App\Attr;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

/**
 * @method $this default($value)
 * @method $this parent(Definition $value)
 * @method $this name($value)
 * @method $this noApi(bool $value = true)
 * @method $this required(bool $value = true)
 * @property string                                            $name
 * @property Type                                              $type
 * @property array                                             $api
 * @property \Illuminate\Support\Collection|array|Definition[] $children
 * @property Definition|null                                   $parent
 * @property boolean                                           $noApi
 * @property mixed                                             $default
 * @property boolean                                           $required
 *
 * @method static Type STRING()
 * @method static Type BOOL()
 * @method static Type INT()
 * @method static Type FLOAT()
 * @method static Type ARRAY()
 * @method static Type MIXED()
 * @method static Type RECURSIVE()
 * @method static Type RECURSE()
 * @method static Type MAP()
 *
 */
class Definition extends Fluent
{
    const STRING = Type::STRING;
    const BOOL = Type::BOOL;
    const INT = Type::INT;
    const FLOAT = Type::FLOAT;
    const ARRAY = Type::ARRAY;
    const MIXED = Type::MIXED;
    const RECURSIVE = Type::RECURSIVE;
    const RECURSE = Type::RECURSE;
    const MAP = Type::MAP;

    public static function __callStatic($name, $arguments)
    {
        if (in_array($name, Type::getNames(), true)) {
            return forward_static_call_array([ Type::class, $name ], $arguments);
        }
    }

    public function __construct($parent = null, array $attributes = [])
    {
        $children = new Collection();
        parent::__construct(array_merge(compact('parent', 'children'), $attributes));
        $this
            ->parent($parent)
            ->name('root')
            ->type('array')
            ->api('Mixed');
    }

    public function clone()
    {
        $clone           = new static($this->parent, $this->attributes);
        $clone->children = $this->children->map(function (Definition $child) {
            return $child->clone();
        });
        return $clone;
    }

    /** @param Type|string $value */
    public function type($value)
    {
        if ( ! $value instanceof Type) {
            $value = Type::get($value);
        }
        if ( ! $this->api) {
            $this->api($value->toApiType());
        }
        $this->attributes[ 'type' ] = $value;
        return $this;
    }

    public function end()
    {
        return $this->parent ?? $this;
    }

    /**
     * api method
     *
     * @param string|array $type
     * @param array|null   $options
     *
     * @return $this
     */
    public function api($type, array $options = [])
    {
        if (is_array($type)) {
            $this->attributes[ 'api' ] = $type;
        } else {
            $this->attributes[ 'api' ] = compact('type', 'options');
        }
        return $this;
    }

    /** @param Type|string $type */
    public function child($name, $type = null, $default = null, $apiType = null)
    {
        if ( ! $this->children->has($name)) {
            $this->children->put($name, with(new self($this))->name($name));
        }
        /** @var static $child */
        $child = $this->children->get($name);
        if ($type !== null) {
            $child->type($type);
        }
        if ($default !== null) {
            $child->default($default);
        }
        if ($apiType !== null) {
            $child->api($apiType);
        }
        return $child;
    }

    public function toArray()
    {
        $children = $this->children->toArray();
        return array_merge(parent::toArray(), compact('children'));
    }

    public function getPath()
    {
        $segments = [ $this->name ];
        $parent   = $this->parent;
        while ($parent) {
            $segments[] = $parent->name;
            $parent     = $parent->parent;
        }
        return implode('.', array_reverse($segments));
    }

    public function hasParent()
    {
        return $this->parent !== null;
    }

    public function hasChild($name)
    {
        return $this->children->has($name);
    }

    public function hasChildren()
    {
        return $this->children->isNotEmpty();
    }

    public function createConfigNode($value = null)
    {
        return new ConfigNode($this, $value);
    }
}
