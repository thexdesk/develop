<?php

namespace App\Attributes\Builder;

class IntegerNodeDefinition extends \Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition
{
    use WithApiTypes;

    public function getDefaultApiType()
    {
        return 'Int';
    }
}
