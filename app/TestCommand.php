<?php

namespace App;

use Codex\Attributes\AttributeDefinition;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\Commands\BuildDefinitionConfig;
use Codex\Attributes\Commands\BuildDefinitionSchema;
use Codex\Filesystem\Local;
use Codex\Filesystem\Utils\Copier;
use Codex\Git\Commands\SyncProject;
use Codex\Git\Config\GitConfig;
use Codex\Git\Console\CodexGitSyncCommand;
use Http\Adapter\Guzzle6\Client as GuzzleClient;
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
        $projectKey = 'codex-git';
        $project    = codex()->getProject($projectKey);
        $git        = $project->git();
        $gitData    = $git->toArray();

        $master = $project->getRevision('master');
        $v1     = $project->getRevision('v1');
        CodexGitSyncCommand::attachConsoleTableListener($this);
        $this->dispatch(with(new SyncProject($projectKey, true)));

        $document=$master->getDocument('index');
        $content  = $document->render();

        return;
        if ( ! $project->hasRevision('master')) {
            return;
        }
        $revision = $project->getRevision('master');

//        $document = $revision->getDocument('getting-started/core-concepts');
        $document = $revision->getDocument('writing-reference/markdown-extensions');
        $content  = $document->render();
        $data     = [
            'project'  => $project->toArray('*'),
            'revision' => $revision->toArray('*'),
            'document' => $document->toArray('*'),
        ];

        $description = $document[ 'description' ];

        $this->line($content);
    }

    public function han345345dle()
    {
        $from  = new Local(storage_path('codex/git/35e1da08eef1b5df1b65ea636ab2cad7/core-master'));
        $paths = $from->glob([
            'resources/docs/*',
            'resources/docs',
            'resources/assets/**/*',
        ]);

        $dirs = $paths->directories();

        $without = $paths->withoutDirectoryChildren();

        $to     = base_path('.tmp/test-copier');
        $copier = new Copier($from, $to);
        $copier->copy('resources/docs/index.md', 'index.md');
        $copier->copy('resources/docs/index.md', 'docs/index.md');
        $copier->copy('resources/docs/*', 'docs2/');

        return;
    }

    public function hand4324234le()
    {

        $builder = new \Github\HttpClient\Builder(new GuzzleClient());
        $client  = new \Github\Client($builder, 'v3');
        $client->authenticate(env('CODEX_GIT_GITHUB_TOKEN'), \Github\Client::AUTH_HTTP_TOKEN);
//        $client->authenticate(env('CODEX_GIT_GITHUB_USERNAME'), env('CODEX_GIT_GITHUB_PASSWORD'), \Github\Client::AUTH_HTTP_PASSWORD);
        $me = $client->me()->show();
//        $auths = $client->authorizations()->all();

        $team = $client->organizations()->show('codex-project');
        return;
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


