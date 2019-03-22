<?php

namespace Codex\AlgoliaSearch;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Vinkla\Algolia\AlgoliaServiceProvider;

class AlgoliaSearchAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-algolia-search' ];

    public $commands = [
        Console\IndexCommand::class,
    ];

    public $providers = [
        AlgoliaServiceProvider::class,
    ];

    public function register()
    {
//        MarkdownParser::macro('getBlocks', function($text){
//            $this->prepare();
//
//            if (ltrim($text) === '') {
//                return '';
//            }
//
//            $text = str_replace(["\r\n", "\n\r", "\r"], "\n", $text);
//
//            $this->prepareMarkers($text);
//
//            $absy = $this->parseBlocks(explode("\n", $text));
//            return $absy;
//        });
    }

    public function boot(AttributeDefinitionRegistry $registry)
    {

    }
}
