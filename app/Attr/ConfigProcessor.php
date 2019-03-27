<?php

namespace App\Attr;

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregatorParameters\ParameterPostProcessor;

class ConfigProcessor
{
    protected $visitors = [
        Visitors\NormalizeVisitor::class,
    ];

    public function process(Definition $definition, array $config = [])
    {
        $node   = $definition->createConfigNode($config);
        $walker = new ConfigNodeWalker($node);
        foreach ($this->visitors as $visitor) {
            $visitor = $this->createVisitor($visitor);
            $walker->walk($node, $visitor);
        }
        $node->getValue();
        return $config;
    }

    protected function createVisitor($callable)
    {
        return app()->make($callable);
    }

    protected function processParameters(array $config)
    {
        $aggregator = new ConfigAggregator(
            [ new ArrayProvider(compact('config')) ],
            null,
            [ new ParameterPostProcessor($config) ]
        );
        $merged     = $aggregator->getMergedConfig();
        $config     = data_get($merged, 'config', $config);
        return $config;
    }
}
