<?php

namespace Codex\Auth\Api;

use Codex\Api\SchemaExtension;

class AuthSchemaExtension extends SchemaExtension
{
    protected $provides = 'codex/auth::schema.auth';

    public function getSchemaExtension(): string
    {
        return '
type AuthServiceData {
    username:String
}
extend type Query {
    auth(service:ID): AuthServiceData @field(resolver: "Codex\\\Auth\\\Api\\\AuthQuery@service")
}
extend type Codex {
    auth(service:ID): AuthServiceData @field(resolver: "Codex\\\Auth\\\Api\\\AuthQuery@service")
}
';
    }
}
