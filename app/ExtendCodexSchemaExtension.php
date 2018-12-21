<?php

namespace App;

use Codex\Api\SchemaExtension;

class ExtendCodexSchemaExtension extends SchemaExtension
{
    protected $provides = 'codex/api::schema.app-codex';


    public function getSchemaExtension(): string
    {
        return "
extend type Codex {
    asdf:String
}";
    }
}
