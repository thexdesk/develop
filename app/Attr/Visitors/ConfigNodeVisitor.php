<?php


namespace App\Attr\Visitors;


use App\Attr\ConfigNode;

interface ConfigNodeVisitor
{
    public function enter(ConfigNode $node);

    public function leave(ConfigNode $node);
}
