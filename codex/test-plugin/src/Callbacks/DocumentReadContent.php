<?php

namespace Codex\TestPlugin\Callbacks;

use Codex\Contracts\Documents\Document;

class DocumentReadContent
{
    public function handle(Document $document)
    {
        $args = func_get_args();
        $content = $document->getContent();


        $a='a';
    }
}
