<?php

namespace App;

use Codex\Attributes\Commands\BuildDefinitionConfig;
use Codex\Attributes\Commands\BuildDefinitionSchema;
use Codex\Attributes\AttributeDefinition;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Git\Config\GitConfig;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\VarDumper\VarDumper;


class TestCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'test';

    public function handle()
    {
        $codex    = codex();
        $project  = $codex->getProject('codex');
        $revision = $project->getRevision('master');
//        $document = $revision->getDocument('getting-started/core-concepts');
        $document = $revision->getDocument('writing-reference/markdown-extensions');
        $content  = $document->render();
        $data = [
            'project' => $project->getAttributes(),
            'revision' => $revision->getAttributes(),
            'document' => $document->getAttributes(),
        ];

        $this->line($content);
    }


    public function h345andle(AttributeDefinitionRegistry $registry)
    {
        $config[ 'codex' ]                = config('codex', []);
        $document                         = codex()->get('codex/master::index');
        $config[ 'codex' ][ 'layout' ]    = $document->attr('layout', []);
        $config[ 'codex' ][ 'projects' ]  = $document->getAttributes();
        $config[ 'codex' ][ 'revisions' ] = $document->getAttributes();
        $config[ 'codex' ][ 'documents' ] = $document->getAttributes();

        $this->dispatchNow(new BuildDefinitionSchema());

        $data[ 'codex' ]     = with(new Processor())->process($this->dispatchNow(new BuildDefinitionConfig($registry->get('codex'))), $config);
        $data[ 'documents' ] = with(new Processor())->process($this->dispatchNow(new BuildDefinitionConfig($registry->get('documents'))), []);
        VarDumper::dump($data);
        return;
    }

    public function han333dle()
    {
        $def = config('codex-git.def.git', []);

        $codex   = codex();
        $project = $codex->getProject('codex');
        $project->set('git', $def);
        $git     = new GitConfig($project, app('codex.git.manager'));
        $remotes = $git->getRemotes();
        $syncs   = $git->getSyncs();
        $links   = $git->getLinks();
//        $revision = $project->getRevision('master');
//        $document = $revision->getDocument('writing-reference/markdown-extensions');
//        $content  = $document->render();
        $data  = collect(compact('remotes', 'syncs', 'links'));
        $array = $git->toArray();
        VarDumper::dump($git->toArray());

        return;
    }

    protected function conf()
    {
        $config = app()->make('codex.config');
        $config->set('exptest2.first', 'first');
        $config->set('exptest2.second', [ 'third' => 'third' ]);
        $config->set('exptest2.third', [ 'first' => '%exptest2.first% and %exptest2.first%', 'second' => '%exptest2.second%' ]);
        $config->set('exptest2.fourth', [ 'first' => '%exptest2.first% and %exptest2.first%', 'second' => '%exptest2.third%' ]);
        $val = $config->get('exptest2');
        return $val;
    }
}


class SchemaGenerator
{
    /** @var \App\DefinitionRegistry */
    protected $registry;

    protected $types = [];

    /**
     * SchemaGenerator constructor.
     *
     * @param \App\DefinitionRegistry $registry
     */
    public function __construct(\Codex\Attributes\AttributeDefinitionRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function generate()
    {

        $this->types = [];
        foreach ($this->registry->keys() as $groupName) {
            $group                     = $this->registry->resolve($groupName);
            $groupType                 = 'extend type ' . studly_case(str_singular($group->name));
            $this->types[ $groupType ] = [];
            $this->generateChildren($group->children, $this->types[ $groupType ]);
        }

        $generated = collect($this->types)->map(static function ($fields, $type) {
            $fields = collect($fields)->map(static function ($type, $name) {
                return "\t{$name}: {$type}";
            })->implode("\n");
            return "{$type} {\n{$fields}\n}";
        })->implode("\n");

        return $generated;
    }

    /**
     * generateChildren method
     *
     * @param array|AttributeDefinition[] $children
     * @param array                       $parent
     *
     * @return void
     */
    protected function generateChildren(array $children, array &$parent)
    {
        foreach ($children as $child) {
            if ($child->noApi === true) {
                continue;
            }
            $apiType                = $child->apiType;
            $parent[ $child->name ] = $this->toFieldTypeString($apiType);
            if ($apiType->new || $apiType->extend) {
                $this->types[ $this->toObjectTypeString($apiType) ] = [];
                if ($child->hasChildren()) {
                    $this->generateChildren($child->children, $this->types[ $this->toObjectTypeString($apiType) ]);
                }
            }
        }
    }

    protected function toFieldTypeString(array $api)
    {
        $type = $api[ 'type' ];
        $opts = data_get($api, 'options', []);

        $parts = [ $type ];
        if ($opts[ 'nonNull' ]) {
            $parts[] = '!';
        }
        if ($opts[ 'array' ]) {
            array_unshift($parts, '[');
            $parts[] = ']';
        }
        if ($opts[ 'array' ] && $opts[ 'arrayNonNull' ]) {
            $parts[] = '!';
        }
        return implode('', $parts);
    }

    protected function toObjectTypeString(array $api)
    {
        return ($api[ 'options' ][ 'extend' ] ? 'extend ' : '') . 'type ' . $api[ 'type' ];
    }

}

class Resolver
{

}


