<?php

namespace Codex\TestPlugin;

use Codex\Documents\Events\ResolvedDocument;

class AddDocumentCallbacks
{
    public function handle(ResolvedDocument $event)
    {
        $document = $event->getDocument();
        $document->on('read_content', Callbacks\DocumentReadContent::class . '@handle');
    }
}
