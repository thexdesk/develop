<?php

namespace App\Attr\Visitors;

use App\Attr\ConfigNode;
use Codex\Exceptions\InvalidConfigurationException;
use Illuminate\Contracts\Validation\Factory;

class NormalizeVisitor implements ConfigNodeVisitor, RootAwareVisitorInterface
{
    protected $rootNode;

    protected $parents = [];

    public function enter(ConfigNode $node)
    {
        $value = $node->getValue();
        $rules = $node->getDefinition()->rules;

        $this->parents[] = $node;
    }

    public function leave(ConfigNode $node)
    {
        $this->parents = array_filter($this->parents, static function (ConfigNode $parent) use ($node) {
            return $parent !== $node;
        });

        $this->validate($node);
        // code
    }

    public function setRootNode(ConfigNode $rootNode)
    {
        $this->rootNode = $rootNode;
    }


    protected function validate(ConfigNode $node)
    {
        $value     = $node->getValue();
        $rules     = $node->getDefinition()->rules;
        $validator = $this->getValidator(compact('value'), [ 'value' => $rules ]);
        if ($validator->fails()) {
            InvalidConfigurationException::reason('Validation failed', $validator->errors()->first());
        }
    }

    protected function getValidator($data, $rules)
    {
        return resolve(Factory::class)->make($data, $rules);
    }
}
