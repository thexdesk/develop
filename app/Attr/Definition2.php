<?php

namespace App\Attr;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

/**
 * @method $this default($value)
 * @method $this parent(Definition $value)
 * @method $this name($value)
 * @method $this normalize(callable $value)
 * @method $this finalize(callable $value)
 * @method $this noApi(bool $value = true)
 * @method $this allowUndefinedChildren(bool $value = true)
 * @method $this required(bool $value = true)
 * @property string                                            $name
 * @property string                                            $type
 * @property array                                             $rules
 * @property array                                             $api
 * @property \Illuminate\Support\Collection|array|Definition[] $children
 * @property Definition|null                                   $parent
 * @property boolean                                           $noApi
 * @property callable|null                                     $normalize
 * @property callable|null                                     $finalize
 * @property mixed                                             $default
 * @property boolean                                           $allowUndefinedChildren
 * @property boolean                                           $required
 */
class Definition2 extends Fluent
{
    const MIXED = 'mixed';
    const STRING = 'string';
    const BOOLEAN = 'boolean';
    const INTEGER = 'integer';
    const ARRAY = 'array';

    public static $apiTypeMap = [
        self::MIXED   => 'Mixed',
        self::STRING  => 'String',
        self::BOOLEAN => 'Boolean',
        self::INTEGER => 'Int',
        self::ARRAY   => 'Assoc',
    ];

    public static function toApiType(string $type)
    {
        return array_key_exists($type, static::$apiTypeMap) ? static::$apiTypeMap[ $type ] : 'Mixed';
    }

    public function __construct($parent = null)
    {
        $children = new Collection();
        parent::__construct(array_merge(compact('parent', 'children'), []));
        $this
            ->parent($parent)
            ->name('root')
            ->type('array')
            ->validation()
            ->api('Mixed')
            ->allowUndefinedChildren(false);
    }

    public function type($value)
    {
        if ( ! $this->api) {
            $this->api(static::toApiType($value));
        }
        $this->attributes[ 'type' ] = $value;
        return $this;
    }

    public function end()
    {
        return $this->parent ?? $this;
    }

    public function string()
    {
        $this->type('string')->validation('string');
        return $this;
    }

    public function integer()
    {
        $this->type('integer')->validation('integer');
        return $this;
    }

    public function array()
    {
        $this->type('array')->validation('array');
        return $this;
    }

    public function boolean()
    {
        $this->type('boolean')->validation('boolean');
        return $this;
    }

    /** @param string|string[]|null $rules */
    public function validation($rules = null, $overwrite = false)
    {
        $rules = $this->getValidationValue($rules);
        if ($overwrite) {
            $this->attributes[ 'rules' ] = $rules;
        } else {
            $this->attributes[ 'rules' ] = array_replace($this->get('rules', []), $rules);
        }
        return $this;
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

    /** @param array|string|null $value */
    protected function getValidationValue($value)
    {
        if ($value === null) {
            $value = [];
        }
        if (is_string($value)) {
            $value = explode('|', $value);
        }
        $value = Arr::wrap($value);
        if ($this->required && ! \in_array('required', $value, true)) {
            $value[] = 'required';
        }
        return $value;
    }

    public function child($name, $type = null, $default = null, $apiType = null)
    {
        if ( ! $this->children->has($name)) {
            $this->children->put($name, with(new static($this))->name($name));
        }
        /** @var static $child */
        $child = $this->children->get($name);
        if ($type) {
            $child->type($type);
        }
        if ($default) {
            $child->default($default);
        }
        if ($apiType) {
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

    public function createConfigNode($value = null)
    {
        return new ConfigNode($this, $value);
    }
}
