<?php

namespace App;

use App\Attr\AttrDemo;
use App\Attr\Definition;
use App\Attr\DefinitionRegistry;
use App\Attr\Type as T;
use Codex\Commands\CompileBladeString;
use Codex\Git\Config\GitConfig;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\VarDumper\VarDumper;


class TestCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'test';

    public function handle()
    {
        $config             = config('codex', []);
        $config[ 'layout' ] = codex()->get('codex/master::index')->attr('layout', []);
        $registry           = new DefinitionRegistry();
        $codex              = $registry->codex;
        $codex->child('changes', T::ARRAY(T::STRING)); //->default([]);
        $cache = $codex->child('cache', T::MAP)->api('CacheConfig', [ 'new' ]);

        $cache->child('enabled', T::BOOL, true);
        $cache->child('key', T::STRING);
        $cache->child('minutes', T::INT);

        $codex->child('display_name', T::STRING, 'Codex')->required();
        $codex->child('description', T::STRING, '');
        $codex->child('default_project', T::STRING)->api('ID')->required();

        $urls = $codex->child('urls', T::MAP, [])->api('CodexUrls', [ 'new' ]);
        $urls->child('api', T::STRING);
        $urls->child('root', T::STRING);
        $urls->child('documentation', T::STRING);

        $paths = $codex->child('paths', T::MAP)->noApi();
        $paths->child('docs', T::STRING);
        $paths->child('log', T::STRING);

        $processors = $codex->child('processors', T::MAP, [])->noApi();
        $processors->child('enabled', T::MAP, []);

        $http = $codex->child('http', T::MAP)->api('HttpConfig', [ 'new' ]);
        $http->child('prefix', T::STRING);
        $http->child('api_prefix', T::STRING);
        $http->child('documentation_prefix', T::STRING);
        $http->child('documentation_view', T::STRING);
        $http->child('backend_data_url', T::STRING);

        $menu = new Definition();
        $menu->name('menu')->type(T::RECURSIVE)->api('MenuItem', [ 'array', 'new' ]);
        $menu->child('id', T::STRING, 'ID', function () {
            return md5(str_random());
        });
        $menu->child('type', T::STRING);
        $menu->child('class', T::STRING);
        $menu->child('side', T::STRING);
        $menu->child('target', T::STRING, 'self');
        $menu->child('href', T::STRING);
        $menu->child('path', T::STRING);
        $menu->child('renderer', T::STRING);
        $menu->child('expand', T::BOOL);
        $menu->child('selected', T::BOOL);
        $menu->child('label', T::STRING);
        $menu->child('sublabel', T::STRING);
        $menu->child('icon', T::STRING);
        $menu->child('color', T::STRING);
        $menu->child('project', T::STRING);
        $menu->child('revision', T::STRING);
        $menu->child('document', T::STRING);
        $menu->child('projects', T::BOOL);
        $menu->child('revisions', T::BOOL);
        $menu->child('children', T::RECURSE)->api('MenuItem', [ 'array' ]);

        //region: layout
        $layout                  = $codex->child('layout', T::MAP)->api('Layout', [ 'new' ]);
        $addLayoutPart           = static function (string $name, string $apiType) use ($layout) {
            $part = $layout->child($name, T::MAP)->api($apiType, [ 'new' ]);
            $part->child('class', T::MAP, []);
            $part->child('style', T::MAP, []);
            $part->child('color', T::STRING, null);
            $part->child('children', T::ARRAY(T::MAP), null, '[Assoc]'); //->api('LayoutToolbarItem', [ 'new'])->default([]);
            return $part;
        };
        $addLayoutHorizontalSide = static function (string $name, string $apiType) use ($addLayoutPart) {
            $part = $addLayoutPart($name, $apiType);
            $part->child('show', T::BOOL, true);
            $part->child('collapsed', T::BOOL, false);
            $part->child('outside', T::BOOL, true);
            $part->child('width', T::INT, 200);
            $part->child('collapsedWidth', T::INT, 50);
            $part->child('fixed', T::BOOL, false);
            return $part;
        };
        $addLayoutVerticalSide   = static function (string $name, string $apiType) use ($addLayoutPart) {
            $part = $addLayoutPart($name, $apiType);
            $part->child('show', T::BOOL, true);
            $part->child('fixed', T::BOOL, false);
            $part->child('height', T::INT, 64);
            return $part;
        };

        $layoutContainer = $addLayoutPart('container', 'LayoutContainer');
        $layoutContainer->child('stretch', T::BOOL, true);

        $layoutHeader = $addLayoutVerticalSide('header', 'LayoutHeader');
        $layoutHeader->children->put('menu', $menu);
        $layoutHeader->child('show_left_toggle', T::BOOL, false);
        $layoutHeader->child('show_right_toggle', T::BOOL, false);

        $layoutFooter = $addLayoutVerticalSide('footer', 'LayoutFooter');
//        $layoutFooter->children->put('menu', $menu);
        $layoutFooter->child('text', T::STRING);

        $layoutLeft = $addLayoutHorizontalSide('left', 'LayoutLeft');
        $layoutLeft->children->put('menu', $menu);

        $layoutRight = $addLayoutHorizontalSide('right', 'LayoutRight');
//        $layoutRight->children->put('menu', $menu);


        $layoutMiddle = $addLayoutPart('middle', 'LayoutMiddle');
        $layoutMiddle->child('padding', T::MIXED, 0);
        $layoutMiddle->child('margin', T::MIXED, 0);

        $layoutContent = $addLayoutPart('content', 'LayoutContent');
        $layoutContent->child('padding', T::MIXED, 0);
        $layoutContent->child('margin', T::MIXED, 0);

        $layoutToolbar = $addLayoutPart('toolbar', 'LayoutToolbar');
//        $layoutToolbar->child('breadcrumbs', 'dictionaryPrototype', '[Assoc]');
//        $layoutToolbar->child('left', 'dictionaryPrototype', '[Assoc]'); //->setApiType('LayoutToolbarItem', [ 'new'])->setDefault([]);
//        $layoutToolbar->child('right', 'dictionaryPrototype', '[Assoc]'); //->setApiType('LayoutToolbarItem', [ 'new'])->setDefault([]);

//        $layout           = $codex->child('layout', T::MAP);
//        $layoutHeader     = $layout->child('header', T::MAP);
//        $layoutHeaderMenu = $layoutHeader->child('menu', T::ARRAY(T::MAP), []);

        //endregion



//        $rootBuilder = new TreeBuilder('root');
//        $rootNode    = $rootBuilder->getRootNode();
//        $rootNode->ignoreExtraKeys(true);
//        $rootNodeBuilder = $rootNode->addDefaultsIfNotSet()->children();

        $tree = $this->dispatch(new BuildDefinitionConfig($registry->getGroup('codex')));

        data_set($config, 'processors.enabled', [ 'phpdoc' => true ]);
        $data   = with(new Processor())->process($tree, [ 'codex' => $config ]);
        $header = data_get($data, 'layout.header', []);
        VarDumper::dump($header);
        return;
    }








//            if($type->isChildType()){
//                $parentNode->ignoreExtraKeys();
//                $node = $parentNode->children()->arrayNode($definition->name);
//
//                $childType = $type->getChildType();
//                if($type->is(T::ARRAY)){
////                    $node = $node->arrayPrototype()->variablePrototype();
//                } elseif($type->is(T::MAP)){
//
//                } else {
//                    $node=$node->prototype(
//                        T::getConfigNodeTypeName($definition->type)
//                    );
//                }
//            } elseif ($definition->type->is(T::ARRAY)) {
////                $node = $parentNode->children()->arrayNode($definition->name);
//            } else {
//                $node = $parentNode->children()->node(
//                    $definition->name,
//                    T::getConfigNodeTypeName($definition->type)
//                );
////                return;
//            }
//            if ($definition->type->is(T::ARRAY)) {
//                $childType = $definition->type->getChildType();
//                $node = $parentNode->children()->arrayNode($definition->name);
//
//                if ($childType->isChildType()) {
//                    $parentNode->ignoreExtraKeys();
//                    $node = $parentNode->children()->arrayNode($definition->name);
//                    $node->ignoreExtraKeys();
//                    $node = $node->arrayPrototype()->variablePrototype();
//                    return;
//                } else {
//                    ->prototype(
//                        T::getConfigNodeTypeName($definition->type)
//                    );
//                    return;
//                }
//            } elseif ($definition->type->is(T::MAP)) {
//                if ($definition->hasChildren()) {
//                    $node = $parentNode->children()->arrayNode($definition->name);
//                    $node->addDefaultsIfNotSet();
//                    $node->ignoreExtraKeys();
//                } else {
//                    $node = $parentNode->children()->arrayNode($definition->name)->arrayPrototype();
//                    $node->ignoreExtraKeys();
//                    return;
//                    $nodeChild = $node->children()->arrayNode($definition->name);
//                    $nodeChild = $nodeChild->ignoreExtraKeys();
//                    $nodeChild = $nodeChild->variablePrototype();
//                }
//            } else {
//                $node = $parentNode->children()->node(
//                    $definition->name,
//                    T::getConfigNodeTypeName($definition->type)
//                );
//                return;
//            }
    public function hand555le()
    {
        $codex    = codex();
        $project  = $codex->getProject('codex');
        $revision = $project->getRevision('master');
//        $document = $revision->getDocument('getting-started/core-concepts');
        $document = $revision->getDocument('writing-reference/markdown-extensions');
        $content  = $document->render();
        $this->line($content);
    }

    public function han333dle()
    {
        $def = config('codex-git.def.git', []);

        $codex   = codex();
        $project = $codex->getProject('codex');
        $project->set('git', $def);
        $git = new GitConfig($project, app('codex.git.manager'));

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

    public function hand4le3()
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


