<?php

namespace Codex\Phpdoc\Serializer\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\VisitorInterface;

class LaravelCollectionHandler implements SubscribingHandlerInterface
{

    public static function getSubscribingMethods()
    {
        $methods         = [];
        $formats         = [ 'json', 'xml', 'yml' ];
        $collectionTypes = [
            'LaravelCollection',
        ];

        foreach ($collectionTypes as $type) {
            foreach ($formats as $format) {
                $methods[] = [
                    'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                    'type'      => $type,
                    'format'    => $format,
                    'method'    => 'serializeCollection',
                ];

                $methods[] = [
                    'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                    'type'      => $type,
                    'format'    => $format,
                    'method'    => 'deserializeCollection',
                ];
            }
        }

        return $methods;
    }

    public function serializeCollection(VisitorInterface $visitor, $collection, array $type, Context $context)
    {
        // We change the base type, and pass through possible parameters.
        $type[ 'name' ] = 'array';

        if ($collection instanceof LaravelCollection) {
            $collection = $collection->all();
        }

        return $visitor->visitArray($collection, $type, $context);
    }

    public function deserializeCollection(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        // See above.
        $type[ 'name' ] = 'array';

        return new LaravelCollection($visitor->visitArray($data, $type, $context));
    }
}
