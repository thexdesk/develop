<?php

namespace Codex\AlgoliaSearch\Console;

use Codex\AlgoliaSearch\Indexer;
use Codex\Codex;
use Codex\Documents\Processors\ParserProcessorExtension;
use Illuminate\Console\Command;
use Vinkla\Algolia\AlgoliaManager;

class IndexCommand extends Command
{
    protected $signature = 'codex:algolia:index';

    public function handle(Codex $codex, AlgoliaManager $client, ParserProcessorExtension $processor)
    {
        $index = $client->initIndex('docs_tmp');

        $include = [ 'codex/master' ];

        foreach ($include as $id) {
            /** @var \Codex\Contracts\Revisions\Revision $revision */
            $revision = $codex->get($id);
            app()->make(Indexer::class)
                ->indexRevision($revision)
                ->finalize();
        }


        $a = 'a';
    }

    protected function getBlockContentText($block)
    {
        if ( ! isset($block[ 'content' ])) {
            return '';
        }

        foreach ($block[ 'content' ] as $sub) {

        }
    }
}
