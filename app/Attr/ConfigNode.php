<?php

namespace App\Attr;

use Closure;
use Codex\Exceptions\InvalidConfigurationException;
use Illuminate\Contracts\Validation\Factory;

class ConfigNode
{
    /** @var \App\Attr\Definition */
    protected $definition;

    /** @var mixed */
    protected $value;

    public function __construct(Definition $definition, $value)
    {
        $this->definition = $definition;
        $this->value      = $value;
    }

    public function normalize($value)
    {
        if ( ! isset($value) && isset($this->definition->default)) {
            $value = $this->definition->default;
        }

        $normalize = $this->definition->normalize;
        if ($normalize instanceof Closure) {
            $value = $normalize($value);
        }

        return $value;
    }

    public function finalize($value)
    {
        if ( ! isset($value) && isset($this->definition->default)) {
            $value = $this->definition->default;
        }

        $finalize = $this->definition->finalize;
        if ($finalize instanceof Closure) {
            $value = $finalize($value);
        }

        $this->validate($value);

        return $value;
    }

    protected function validate($value)
    {
        $validators = [ $this->validateValue($value), $this->validateValueChildren($value) ];
        foreach ($validators as $validator) {
            if ( ! $validator->passes()) {
                throw InvalidConfigurationException::reason($this->getName(), $validator->errors()->first());
            }
        }
        return true;
    }

    protected function getValidator($data, $rules)
    {
        return resolve(Factory::class)->make($data, $rules);
    }

    protected function validateValue($value)
    {
        return $this->getValidator(compact('value'), $this->definition->rules[ 'value' ]);
    }

    protected function validateValueChildren($value)
    {
        if ( ! is_array($value)) {
            return $this->getValidator([], []);
        }
        $rules = array_fill_keys(array_keys($value), $this->definition->rules[ 'children' ]);
        return $this->getValidator($value, $rules);
    }

    /** @var \App\Attr\ConfigNode[] */
    protected $children;

    /** @return \App\Attr\ConfigNode[] */
    public function getChildren()
    {
        if ($this->children === null) {
//            $definition       = $this->getDefinition();
//            $childDefinitions = $definition->children;
//            $children         = [];
//            if (is_array($this->value)) {
//                foreach ($this->value as $childKey => $childValue) {
//                    $hasDefinition = $childDefinitions->has($childKey);
//                    if ( ! $hasDefinition && $definition->allowUndefinedChildren) {
//                        $children[ $childKey ] = [ 'value' => $childValue ];
//                    }
//                }
//                foreach ($this->getDefinition()->children as $childDefinition) {
//
//                }
//            }
            $this->children = $this->getDefinition()->children->transform(function (Definition $definition) {
                $value = data_get($this->value, $definition->name);
                return $definition->createConfigNode($value);
            });
        }
        return $this->children;
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function getName()
    {
        return $this->definition->name;
    }

    public function hasDefault()
    {
        return $this->definition->offsetExists('default');
    }

    public function getDefault()
    {
        return $this->definition->default;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }


}




//protected function callOnChildren($value, callable $onChildCb, callable $onNotExistChildCb = null)
//{
//
////        foreach ($value as $childKey => $childValue) {
////
////        }
//    foreach ($this->definition->children as $childDefinition) {
//        $childNode  = $childDefinition->createConfigNode();
//        $childValue = null;
//        if (array_key_exists($childDefinition->name, $value)) {
//            $childValue = $value[ $childDefinition->name ];
//        }
//        if (array_key_exists($childDefinition->name, $value) || $childNode->hasDefault()) {
//            $onChildCb($childNode, $childValue, $value);
//        } elseif($onNotExistChildCb !== null) {
//            $onNotExistChildCb($childNode, $childValue, $value);
//        }
//    }
//    return $value;
//}
//protected function diff_recursive($array1, $array2)
//{
//    foreach ($array1 as $key => $value) {
//        if (is_array($value)) {
//            if ( ! isset($array2[ $key ])) {
//                $difference[ $key ] = $value;
//            } elseif ( ! is_array($array2[ $key ])) {
//                $difference[ $key ] = $value;
//            } else {
//                $new_diff = $this->diff_recursive($value, $array2[ $key ]);
//                if ($new_diff != FALSE) {
//                    $difference[ $key ] = $new_diff;
//                }
//            }
//        } elseif ( ! array_key_exists($key, $array2) || $array2[ $key ] != $value) {
//            $difference[ $key ] = $value;
//        }
//    }
//    if ( ! isset($difference)) {
//        return 0;
//    }
////        if (is_int(head(array_keys($difference)))) {
////            $difference = array_values($difference);
////        }
//    return $difference;
//}


//        $value = $this->callOnChildren($value,
//            function (ConfigNode $childNode, $childValue, &$value) {
//                $value[ $childNode->getName() ] = $childNode->finalize($childValue);
//            },
//            function (ConfigNode $childNode, $childValue, &$value) {
//                $value[ $childNode->getName() ] = $childNode->finalize($childValue);
//            });
