<?php

namespace Codex\Comments\Documents;

use Codex\Attributes\AttributeDefinition;
use Codex\Comments\CommentsManager;
use Codex\Contracts\Documents\Document;
use Codex\Documents\Processors\ProcessorExtension;
use Codex\Documents\Processors\ProcessorInterface;

class CommentsProcessorExtension extends ProcessorExtension implements ProcessorInterface
{
    protected $defaultConfig = [];

    protected $after = [ '*' ];

    /** @var \Codex\Comments\CommentsManager */
    protected $comments;

    public function __construct(CommentsManager $comments)
    {
        $this->comments = $comments;
    }


    public function getName()
    {
        return 'comments';
    }

    public function defineConfigAttributes(AttributeDefinition $definition)
    {
        $definition->add('connection', 'string')->setDefault(config('codex-comments.default'));
    }

    public function process(Document $document)
    {
        $revision   = $document->getRevision();
        $project    = $document->getProject();
        $connection = $this->config('connection');
        $config     = $this->comments->getConnectionConfig($connection);
        $comments   = $this->comments->connection($connection);
        $data       = $comments->render([
            'url' => $document->url(),
            'id'  => "{$project}/{$revision}::{$document}",
        ]);
        $document->set('comments.enabled', true);
        $document->set('comments.driver', $config[ 'driver' ]);
        $document->set('comments.connection', $connection);

        if ($data[ 'script' ]) {
            $scriptUrl         = route('codex.comments.script');
            $scriptQueryString = http_build_query([
                'connection' => $connection,
                'url'        => $document->url(),
                'id'         => "{$project}/{$revision}::{$document}",
            ]);
            $document->push('scripts', "{$scriptUrl}?{$scriptQueryString}");
        }

        if ($data[ 'html' ]) {
            $document->setContent($document->getContent() . $data[ 'html' ]);
        }
    }
}
