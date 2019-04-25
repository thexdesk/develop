<?php


namespace Codex\Packagist;


use Codex\Attributes\AttributeType as T;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;

class PackagistAttributeExtension extends AttributeExtension
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        T::STRING;
    }
}

