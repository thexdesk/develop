<?php


namespace App\Attr\Visitors;


use App\Attr\ConfigNode;

interface RootAwareVisitorInterface
{
    public function setRootNode(ConfigNode $rootNode);
}
