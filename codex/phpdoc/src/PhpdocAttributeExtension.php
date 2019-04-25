<?php


namespace Codex\Phpdoc;

use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeExtension;
use Codex\Attributes\AttributeType as T;
use Codex\Phpdoc\Serializer\AttributeAnnotationReader;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;

class PhpdocAttributeExtension extends AttributeExtension
{
    public function register(AttributeDefinitionRegistry $registry)
    {
        $reader = app()->make(AttributeAnnotationReader::class);
        $registry->codex->getChild('urls')->child('phpdoc', T::STRING);
        $phpdoc = $registry->add('phpdoc');
        $phpdoc->child($reader->handleClassAnnotations(PhpdocStructure::class));

        $projects = $registry->projects;
        $phpdoc   = $projects->child('phpdoc', T::MAP)->api('PhpdocConfig', [ 'new' ]);
        $phpdoc->child('enabled', T::BOOL); // => false,
        $phpdoc->child('document_slug', T::STRING); // => 'phpdoc',
        $phpdoc->child('title', T::STRING); // => 'Api Documentation',
        $phpdoc->child('xml_path', T::STRING); // => 'structure.xml',
        $phpdoc->child('doc_path', T::STRING); // => '_phpdoc',
        $phpdoc->child('doc_disabled_processors', T::ARRAY(T::STRING)); // => [ 'header', 'toc' ], //'button',
        $phpdoc->child('view', T::STRING); // => 'codex-phpdoc::document',
        $phpdoc->child('layout', T::MAP, 'Layout'); // => require __DIR__ . '/codex-phpdoc.layout.php',
        $phpdoc->child('default_class', T::STRING); // => null,

        $registry->revisions->inheritKeys('phpdoc');
    }
}
