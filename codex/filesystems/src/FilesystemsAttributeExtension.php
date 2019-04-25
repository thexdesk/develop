<?php


namespace Codex\Filesystems;


use Codex\Attributes\AttributeType as T;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;

class FilesystemsAttributeExtension extends AttributeExtension
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        T::STRING;
    }
}
