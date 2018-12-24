<?php

namespace Codex\Phpdoc;

use Codex\Api\SchemaExtension;

class PhpdocSchemaExtension extends SchemaExtension
{
    protected $provides = 'codex/core::schema.phpdoc';

    public function getSchemaExtension(): string
    {
        return '
type PhpdocQuery {
    title: String
    version: String
    file(hash: String, fullName: String): PhpdocFile @field(resolver: "Codex\\\Phpdoc\\\Api\\\PhpdocQuery@file")
}
extend type Query {
    phpdoc(projectKey:ID, revisionKey:ID): PhpdocQuery @field(resolver: "Codex\\\Phpdoc\\\Api\\\PhpdocQuery@phpdoc")
}
';
    }
}
