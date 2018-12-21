<?php

namespace App\Attributes\Builder;

class StringNodeDefinition extends ScalarNodeDefinition
{
    protected function instantiateNode()
    {
        return new StringNode($this->name, $this->parent, $this->pathSeparator);
    }

    public function getDefaultApiType()
    {
        return 'String';
    }

}
