<?php

namespace Codex\Phpdoc\Serializer;

use Codex\Documents\Processors\ParserProcessorExtension;
use JMS\Serializer\Accessor\DefaultAccessorStrategy;
use JMS\Serializer\Metadata\PropertyMetadata;

class XmlAccessorStrategy extends DefaultAccessorStrategy
{

    public function getValue($object, PropertyMetadata $metadata)
    {
        return $metadata->getValue($object);
    }

    public function setValue($object, $value, PropertyMetadata $metadata)
    {
        if ($metadata->class === \Codex\Phpdoc\Serializer\Phpdoc\File\Docblock::class) {
            if (\in_array($metadata->name, [ 'long_description', 'description' ]) && $value !== '') {
                $parserExtension = app()->make(ParserProcessorExtension::class);
                $parser          = $parserExtension->makeParser(
                    config($parserExtension->getDefaultConfig() . '.markdown', [])
                );
                $value           = $parser->parse($value);
            }

        }
        $metadata->setValue($object, $value);
    }
}
