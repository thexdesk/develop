<?php

namespace App\Attr\Visitors;

use App\Attr\ConfigNode;
use Codex\Exceptions\InvalidConfigurationException;
use Illuminate\Contracts\Validation\Factory;

class ValidationVisitor implements ConfigNodeVisitor
{

    public function enter(ConfigNode $node)
    {
        // TODO: Implement enter() method.
    }

    public function leave(ConfigNode $node)
    {
    }

}
