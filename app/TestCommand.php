<?php

namespace App;

use App\Attr\AttrDemo;
use Codex\Commands\CompileBladeString;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'test';

    public function handle()
    {
        $this->conf();
        $codex    = codex();
        $project  = $codex->getProject('codex');
        $revision = $project->getRevision('master');
        $document = $revision->getDocument('processors/macros');
        $gitLinks = $document->attr('git_links.links.edit_page');
        $content  = $document->render();
        $attrs    = $document->getAttributes();
        $du       = $document->attr('git_links.links');
        $this->line($content);
    }

    protected function conf()
    {

        $config = app()->make('codex.config');
//        $config->set('exptest.first', 'first');
//        $config->set('exptest.second', [ 'third' => 'third' ]);
//        $config->set('exptest.third', [ 'first' => '% this["first"] % and % this["second"] %', 'second' => '% this["second"] %' ]);
        $config->set('exptest2.first', 'first');
        $config->set('exptest2.second', [ 'third' => 'third' ]);
        $config->set('exptest2.third', [ 'first' => '%exptest2.first% and %exptest2.first%', 'second' => '%exptest2.second%' ]);
        $config->set('exptest2.fourth', [ 'first' => '%exptest2.first% and %exptest2.first%', 'second' => '%exptest2.third%' ]);
        $val = $config->get('exptest2');
        return $val;
    }

    public function handle3()
    {
        $asdf = $this->dispatch(new CompileBladeString(<<<'EOF'
@if($a === 'n')
    {% 'a === n ' %}
@endif
{% 'basePath = ' . $app->basePath() %}
EOF
            ,
            [
                'a'   => 'n',
                'app' => $this->getLaravel(),
            ]
        ));

        $this->dispatch(new AttrDemo());
    }
}

//
//
//interface DefVisitor
//{
//    public function visit(Definition $def);
//
//    public function depart(Definition $def);
//}
//
//class DefWalker
//{
//    public function walk(Definition $def, DefVisitor $visitor)
//    {
//        $visitor->visit($def);
//        foreach ($def->children as $child) {
//            $this->walk($child, $visitor);
//        }
//        $visitor->depart($def);
//    }
//}
//
//class DefValidationVisitor implements DefVisitor
//{
//    protected function getValidator()
//    {
//        return resolve(Factory::class);
//    }
//
//    public function visit(Definition $def)
//    {
//        if ($def->validation) {
////            $this->getValidator()->validate()
//        }
//    }
//
//    public function depart(Definition $def)
//    {
//        // TODO: Implement depart() method.
//    }
//}
//
//
//

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
    public function __construct(\App\Attr\DefinitionRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function generate()
    {

        $this->types = [];
        foreach ($this->registry->keys() as $groupName) {
            $group                     = $this->registry->resolveGroup($groupName);
            $groupType                 = 'extend type ' . studly_case(str_singular($group->name));
            $this->types[ $groupType ] = [];
            $this->generateChildren($group->children, $this->types[ $groupType ]);
        }

        $generated = collect($this->types)->map(function ($fields, $type) {
            $fields = collect($fields)->map(function ($type, $name) {
                return "\t{$name}: {$type}";
            })->implode("\n");
            return "{$type} {\n{$fields}\n}";
        })->implode("\n");

        return $generated;
    }

    /**
     * generateChildren method
     *
     * @param array|Definition[] $children
     * @param array              $parent
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


