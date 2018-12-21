<?php

namespace App\Attributes\Builder;

class ScalarNodeDefinition extends \Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition
{
    use WithApiTypes;
}
