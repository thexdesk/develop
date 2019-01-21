<?php

namespace Codex\Phpdoc\Api;

use Codex\Api\SchemaExtension;

class PhpdocSchemaExtension extends SchemaExtension
{
    protected $provides = 'codex/core::schema.phpdoc';

    public function getSchemaExtension(): string
    {
        return '
extend type PhpdocManifest {
    file(hash: String, fullName: String): PhpdocFile @field(resolver: "Codex\\\Phpdoc\\\Api\\\PhpdocQuery@file")
}
extend type Query {
    phpdoc(projectKey:ID, revisionKey:ID): PhpdocManifest @field(resolver: "Codex\\\Phpdoc\\\Api\\\PhpdocQuery@phpdoc")
}
extend type Codex {
    phpdoc(projectKey:ID, revisionKey:ID): PhpdocManifest @field(resolver: "Codex\\\Phpdoc\\\Api\\\PhpdocQuery@phpdoc")
}
';
    }
}
