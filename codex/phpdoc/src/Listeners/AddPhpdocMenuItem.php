<?php

namespace Codex\Phpdoc\Listeners;

use Codex\Revisions\Events\ResolvedRevision;

class AddPhpdocMenuItem
{
    public function handle(ResolvedRevision $event)
    {
        $revision = $event->getRevision();
        $revision->push('layout.header.menu', [
            'label' => 'Api',
            'sublabel' => 'Documentation',
            'phpdoc' => ''
        ]);
    }
}
