<?php

namespace Codex\AlgoliaSearch;

use Codex\Codex;
use Codex\Contracts\Documents\Document;
use Codex\Contracts\Revisions\Revision;
use Codex\Documents\Processors\Parser\CommonMarkParser;
use Codex\Documents\Processors\ParserProcessorExtension;
use FluentDOM\DOM\Element;
use Vinkla\Algolia\AlgoliaManager;

class Indexer
{
    /** @var \Codex\Codex */
    protected $codex;

    /** @var \Vinkla\Algolia\AlgoliaManager */
    protected $client;

    /** @var \Codex\Documents\Processors\ParserProcessorExtension */
    protected $processor;

    /** @var \AlgoliaSearch\Index */
    protected $index;

    /**
     * The list of HTML elements and their importance.
     *
     * @var array
     */
    protected $tags = [
        'h1' => 0,
        'h2' => 1,
        'h3' => 2,
        'h4' => 3,
        'h5' => 4,
        'p'  => 5,
        'td' => 5,
        'li' => 5,
    ];

    public function __construct(Codex $codex, AlgoliaManager $client, ParserProcessorExtension $processor)
    {
        $this->codex     = $codex;
        $this->client    = $client;
        $this->processor = $processor;
        $this->index     = $client->initIndex('docs_tmp');
    }

    public function indexRevision(Revision $revision)
    {
        foreach ($revision->getDocuments()->keys() as $documentKey) {
            $document = $revision->getDocument($documentKey);
            $this->indexDocument($document);
        }

        return $this;
    }

    public function indexDocument(Document $document)
    {

        $document->makeVisible($document->getHidden());
        $attributes = $document->attributesToArray();
        $attributes = array_filter($attributes, 'is_string');
        $attributes = array_except($attributes, [ 'content', 'path', 'view' ]);
        $attributes = array_replace($attributes, [
            'objectID' => $document->getProject() . '/' . $document->getRevision() . '::' . $document->getKey(),
            'link'     => $document->url(),
        ]);
        $this->index->addObject($attributes);


        $content  = $this->getDocumentContent($document);
        $query    = $this->queryHtml($content);
        $children = $query->children('h1,h2,h3,h4,h5,p,ul,ol');
        foreach ($children->toArray() as $element) {

            $this->index->addObject($this->getAlgoliaObject($element, $document));
        }

        return $this;
    }

    protected function getDocumentContent(Document $document)
    {
        $parser = app()->make(CommonMarkParser::class);
        $parser->setOptions($document->attr(
            "processors.{$this->processor->getName()}.markdown",
            $this->codex->attr("processors.{$this->processor->getName()}.markdown", [])
        ));
        $content = $document->getContentResolver()($document);
        return $parser->parse($content);
    }

    protected function queryHtml($html)
    {
        $query = \FluentDOM::QueryCss($html, 'html', [
            \FluentDOM\Loader\Options::ENCODING       => 'UTF-8',
            \FluentDOM\Loader\Options::FORCE_ENCODING => false,
        ]);

        return $query->find('body');
    }

    protected function getElementImportance(Element $element)
    {
        $name = $element->tagName;
        if (array_key_exists($name, $this->tags)) {
            return $this->tags[ $name ];
        }
        return null;
    }

    protected function getAlgoliaObject(Element $element, Document $document)
    {
        $tags       = [ 'h1', 'h2', 'h3', 'h4', 'h5' ];
        $attributes = [
            'objectID'   => $document->getProject() . '/' . $document->getRevision() . '::' . $document->getKey() . '-' . md5($element->textContent),
            'link'       => $document->url(),
            'content'    => $element->textContent,
            'importance' => $this->getElementImportance($element),
            '_tags'      => [ $document->getRevision()->getKey() ],
        ];
        return $attributes;
    }

    protected function setSettings()
    {
        $this->index->setSettings([
            'attributesToIndex'         => [
                'unordered(text_h1)',
                'unordered(text_h2)',
                'unordered(text_h3)',
                'unordered(text_h4)',
                'unordered(text_h5)',
                'unordered(h1)',
                'unordered(h2)',
                'unordered(h3)',
                'unordered(h4)',
                'unordered(h5)',
                'unordered(content)',
            ],
            'attributesToHighlight'     => [ 'h1', 'h2', 'h3', 'h4', 'content' ],
            'attributesToRetrieve'      => [ 'h1', 'h2', 'h3', 'h4', '_tags', 'link' ],
            'customRanking'             => [ 'asc(importance)' ],
            'ranking'                   => [ 'words', 'typo', 'attribute', 'proximity', 'custom' ],
            'minWordSizefor1Typo'       => 3,
            'minWordSizefor2Typos'      => 7,
            'allowTyposOnNumericTokens' => false,
            'minProximity'              => 2,
            'ignorePlurals'             => true,
            'advancedSyntax'            => true,
            'removeWordsIfNoResults'    => 'allOptional',
        ]);
    }

    public function finalize()
    {
        $this->setSettings();
        $this->client->moveIndex($this->index->indexName, 'docs');
    }
}
