<?php

namespace Codex\Phpdoc\Documents;

use Codex\Attributes\AttributeDefinition;
use Codex\Contracts\Documents\Document;
use Codex\Documents\Processors\ProcessorExtension;
use Codex\Documents\Processors\ProcessorInterface;

class PhpdocProcessorExtension extends ProcessorExtension implements ProcessorInterface
{
    protected $defaultConfig = [];

    protected $after = [ '*' ];

//    protected $defaultConfig = 'codex.processor-defaults.attributes';

    public function process(Document $document)
    {
        $content = $document->getContent();
        $document->setContent("<phpdoc-manifest-provider  project='{$document->getProject()}' revision='{$document->getRevision()}'>{$content}</phpdoc-manifest-provider>");
    }

    public function getName()
    {
        return 'phpdoc';
    }

    public function defineConfigAttributes(AttributeDefinition $definition)
    {
        // TODO: Implement defineConfigAttributes() method.
    }
}
