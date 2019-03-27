<?php

namespace App\Attr;

use App\Attr\Visitors\ConfigNodeVisitor;
use App\Attr\Visitors\RootAwareVisitorInterface;

class ConfigNodeWalker
{
    /** @var \App\Attr\ConfigNode */
    protected $rootNode;

    public function __construct(ConfigNode $rootNode)
    {
        $this->rootNode = $rootNode;
    }

    public function walk(ConfigNode $node, ConfigNodeVisitor $visitor)
    {
        if ($visitor instanceof RootAwareVisitorInterface) {
            $visitor->setRootNode($this->rootNode);
        }
        $visitor->enter($node);
        foreach ($node->getChildren() as $childNode) {
            $this->walk($childNode, $visitor);
        }
        $visitor->leave($node);
    }
}
