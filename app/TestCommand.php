<?php

namespace App;

use Closure;
use Codex\Addons\AddonCollection;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeSchemaGenerator;
use Codex\Contracts\Projects\Project;
use Codex\Exceptions\InvalidConfigurationException;
use GraphQL\Executor\ExecutionResult;
use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\FieldNode;
use GraphQL\Language\Parser;
use GraphQL\Language\Visitor;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Factory;
use Nuwave\Lighthouse\Schema\AST\ASTHelper;
use Nuwave\Lighthouse\Schema\AST\PartialParser;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Yaml\Yaml;
use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregatorParameters\ParameterPostProcessor;


interface DefVisitor
{
    public function visit(Def $def);

    public function depart(Def $def);
}

class DefWalker
{
    public function walk(Def $def, DefVisitor $visitor)
    {
        $visitor->visit($def);
        foreach ($def->children as $child) {
            $this->walk($child, $visitor);
        }
        $visitor->depart($def);
    }
}

class DefValidationVisitor implements DefVisitor
{
    protected function getValidator()
    {
        return resolve(Factory::class);
    }

    public function visit(Def $def)
    {
        if ($def->validation) {
//            $this->getValidator()->validate()
        }
    }

    public function depart(Def $def)
    {
        // TODO: Implement depart() method.
    }
}

/**
 * @method $this default($value)
 * @method $this parent(Def $value)
 * @method $this name($value)
 * @method $this type($value)
 * @method $this normalize(callable $value)
 * @method $this finalize(callable $value)
 * @method $this noApi()
 * @property string                                     $name
 * @property string                                     $type
 * @property array                                      $rules
 * @property array                                      $api
 * @property \Illuminate\Support\Collection|array|Def[] $children
 * @property Def|null                                   $parent
 * @property boolean                                    $noApi
 * @property callable|null                              $normalize
 * @property callable|null                              $finalize
 * @property mixed                                      $default
 */
class Def extends Fluent
{

    public function __construct($parent = null)
    {
        $children = new Collection();
        parent::__construct(compact('parent', 'children'));
        $this
            ->parent($parent)
            ->name('root')
            ->type('array')
            ->validation()
            ->api('Root', [ 'new' ]);
    }

    public function end()
    {
        return $this->parent ?? $this;
    }

    /**
     * validation method
     *
     * @param array|Rule|null $value
     * @param array|Rule|null $children
     *
     * @return $this
     */
    public function validation($value = null, $children = null)
    {
        if ($value instanceof Rule) {
            $value = $value->get();
        }
        if ($children instanceof Rule) {
            $children = $children->get();
        }
        $this->attributes[ 'rules' ] = [
            'value'    => Arr::wrap($value),
            'children' => Arr::wrap($children),
        ];
        return $this;
    }

    public function child($name, $type, $apiType = null, $default = null)
    {
        if ( ! $this->children->has($name)) {
            $this->children->put($name, with(new static($this))->name($name)->type($type));
        }
        /** @var static $child */
        $child = $this->children->get($name);
        if ($apiType) {
            $child->api($apiType);
        }
        if ($default) {
            $child->default($default);
        }
        return $child;
    }

    public function toArray()
    {
        $children = $this->children->toArray();
        return array_merge(parent::toArray(), compact('children'));
    }

    public function api($type, array $options = [])
    {
        $this->attributes[ 'api' ] = compact('type', 'options');
        return $this;
    }

    public static function rule()
    {
        return new Rule();
    }

    public function createConfigNode()
    {
        return new ConfigNode($this);
    }
}

class ConfigNode
{
    /** @var \App\Def */
    protected $definition;

    public function __construct(Def $definition)
    {
        $this->definition = $definition;
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function getName()
    {
        return $this->definition->name;
    }

    public function hasDefault()
    {
        return $this->definition->offsetExists('default');
    }

    public function getDefault()
    {
        return $this->definition->default;
    }

    public function normalize($value)
    {
        if ( ! isset($value) && isset($this->definition->default)) {
            $value = $this->definition->default;
        }

        $normalize = $this->definition->normalize;
        if ($normalize instanceof Closure) {
            $value = $normalize($value);
        }

        $this->children($value, function ($childNode, $childValue,&$value) {
            $value[$childNode->getName()] = $childNode->normalize($childValue);
        });

//        if ($this->definition->children->isNotEmpty()) {
//            foreach ($this->definition->children as $childDefinition) {
//                $childNode = $childDefinition->createConfigNode();
//                if (array_key_exists($childDefinition->name, $value)) {
//                    $value[ $childDefinition->name ] = $childNode->normalize($value[ $childDefinition->name ]);
//                } elseif ($childNode->hasDefault()) {
//                    $value[ $childDefinition->name ] = $childNode->normalize(null);
//                }
//            }
//        }

        return $value;
    }

    protected function children(&$value, callable $cb)
    {
        if ($this->definition->children->isNotEmpty()) {
            foreach ($this->definition->children as $childDefinition) {
                $childNode  = $childDefinition->createConfigNode();
                $childValue = null;
                if (array_key_exists($childDefinition->name, $value)) {
                    $childValue = $value[ $childDefinition->name ];
                }
                if (array_key_exists($childDefinition->name, $value) || $childNode->hasDefault()) {
                    $cb($childNode, $childValue, $value);
                }
            }
        }
    }

    public function finalize($value)
    {
        if ( ! isset($value) && isset($this->definition->default)) {
            $value = $this->definition->default;
        }

        $finalize = $this->definition->finalize;
        if ($finalize instanceof Closure) {
            $value = $finalize($value);
        }

        $this->validate($value);

        $this->children($value, function ($childNode, $childValue,&$value) {
            $value[$childNode->getName()] = $childNode->finalize($childValue);
        });
//        if ($this->definition->children->isNotEmpty()) {
//            foreach ($this->definition->children as $childDefinition) {
//                $childNode = $childDefinition->createConfigNode();
//                if (array_key_exists($childDefinition->name, $value)) {
//                    $value[ $childDefinition->name ] = $childNode->finalize($value[ $childDefinition->name ]);
//                }
//            }
//        }

        return $value;
    }

    protected function validate($value)
    {
        $validators = [ $this->validateValue($value), $this->validateValueChildren($value) ];
        foreach ($validators as $validator) {
            if ( ! $validator->passes()) {
                throw InvalidConfigurationException::reason($this->getName(), $validator->errors()->first());
            }
        }
        return true;
    }

    protected function getValidator($data, $rules)
    {
        return resolve(Factory::class)->make($data, $rules);
    }

    protected function validateValue($value)
    {
        return $this->getValidator(compact('value'), $this->definition->rules[ 'value' ]);
    }

    protected function validateValueChildren($value)
    {
        if ( ! is_array($value)) {
            return $this->getValidator([], []);
        }
        $rules = array_fill_keys(array_keys($value), $this->definition->rules[ 'children' ]);
        return $this->getValidator($value, $rules);
    }

}

class Processor
{
    public function process(Def $definition, array $config = [])
    {
        $node   = $definition->createConfigNode();
        $config = $node->normalize($config);
        $config = $this->processParameters($config);
        $config = $node->finalize($config);
        $config = $this->processParameters($config);
        return $config;
    }

    protected function processParameters(array $config)
    {
        $aggregator = new ConfigAggregator(
            [ new ArrayProvider(compact('config')) ],
            null,
            [ new ParameterPostProcessor($config) ]
        );
        $merged     = $aggregator->getMergedConfig();
        $config     = data_get($merged, 'config', $config);
        return $config;
    }
}

class Resolver
{

}


class TestCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'test';

    public function handle()
    {


        $def = new Def();

        $def->child('default_attributes', 'array')
            ->validation(Def::rule()->array())
            ->default([])
            ->api('DefaultAttributes', [ 'new' ]);

        $def->child('attributes', 'array')
            ->validation(Def::rule()->array());

        $def->child('names', 'array', '[String]')
            ->default([ 'a', 'b', 'c' ])
            ->validation('array', 'string');

        $def->child('test', 'string', '[String]')
            ->default('%default_attributes.label%')
            ->validation('string');


        $processor = new Processor();
        $c         = $processor->process($def, [
            'default_attributes' => [
                'label' => 'asdf',
            ],
            'attributes'         => [
                'text' => '%default_attributes.label%',
            ],
        ]);

        $codex     = codex();
        $projects  = $codex->getProjects();
        $project   = $projects->get('codex');
        $revisions = $project->getRevisions();
        $revision  = $revisions->get('master');
        $documents = $revision->getDocuments();
//        $document  = $documents->get('getting-started/core-concepts');
        $document          = $documents->get('writing-reference/markdown-extensions');
        $processorsEnabled = $project->attr('processors.enabled');
        $buttons           = $document->attr('processors.buttons');
        $attrs             = $document->setHidden([])->toArray();
        $content           = $document->render();

        return $this->line($content);
    }

    public function handleqqq()
    {


        $r = graphql()->executeQuery(<<<'EOT'
query Test {
    document(projectKey: "codex", revisionKey:"master", documentKey: "index") {
        key
        changes
        content
    }
}
EOT
            , null, []);
        if (count($r->errors) > 0) {
            $this->line($r->errors[ 0 ]->getTraceAsString());
            $this->line($r->errors[ 0 ]->getMessage());
            $this->line(count($r->errors) . ' errors in total');
        }
        $this->line(Yaml::dump($r->data, 10, 4));
    }

    public function handle24234234()
    {
        $changes       = codex()->getChanges();
        $projectQuery  = '{
    project(key: "codex") {
        key
        changes
    }
}';
        $revisionQuery = '{
    revision(projectKey: "codex", revisionKey:"master") {
        key
        changes
    }
}';
        $documentQuery = '{
    document(projectKey: "codex", revisionKey:"master", documentKey: "index") {
        key
        changes
        content
    }
}';


        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json', 'Cache-Control' => 'max-age=9999', 'If-None-Match' => '"bed7af1f60417d5fda8927c887ef6bb6"' ],
        ]);
        $res    = $client->post(route('codex.api'), [
            'json' => [
                [ 'query' => $projectQuery ],
                [ 'query' => $revisionQuery ],
                [ 'query' => $documentQuery ],
            ],
        ]);

        $content = $res->getBody()->getContents();

        $result = codex()->getApi()->executeBatchedQueries([
            [ 'query' => $projectQuery ],
            [ 'query' => $revisionQuery ],
            [ 'query' => $documentQuery ],
        ]);
//        $result        = codex()->getApi()->executeQuery($projectQuery,null,[]);
        $data = array_map(function (ExecutionResult $result) {
            return $result->data;
        }, $result);
        $a    = 'a';
    }

    public function handle345345()
    {
        $codex    = codex();
        $project  = $codex->getProject('codex');
        $revision = $project->getRevision('master');
        $document = $revision->getDocument('index');
        $models   = compact('codex', 'project', 'revision', 'document');
        $changes  = [
            'project'  => $project->getChanges(),
            'revision' => $revision->getChanges(),
            'document' => $document->getChanges(),
        ];
        $result   = [];
        foreach ($project->getInheritKeys() as $key) {
            data_set($result, $key, $codex->attr($key));
        }
        foreach ($changes as $name => $changed) {
            foreach (array_keys(array_dot($changed)) as $key) {
                $key = head(preg_split('/\.\d/', $key));
                if (array_has($result, $key)) {
                    continue;
                }
                data_set($result, $key, $models[ $name ]->attr($key));
            }
        }
        $a = 'a';
    }

    public function handle5345()
    {
        $develop = codex()->get('codex/develop::!');
        $master  = codex()->get('codex/master::!');


//        $this->line( SchemaPrinter::doPrint(
//            graphql()->prepSchema()
//        ));
        $r = graphql()->executeQuery(<<<'EOT'
query Test {
    diff(right: "codex/master::!") {
        attributes
    }
}
EOT
            , null, []);
        if (count($r->errors) > 0) {
            $this->line($r->errors[ 0 ]->getTraceAsString());
            $this->line($r->errors[ 0 ]->getMessage());
            $this->line(count($r->errors) . ' errors in total');
        }
        $this->line(Yaml::dump($r->data, 10, 4));
        $a = 'a';
    }


    public function handle234dd234(AttributeDefinitionRegistry $registry, Filesystem $fs, AttributeSchemaGenerator $generator)
    {
        codex()->getLog()->useArtisan($this);
        $project = codex()->getProject('blade-extensions');

//        $this->dispatchNow(new SyncGitProject('blade-extensions'));

        $revision = $project->getRevision('develop');
        $p        = $revision->phpdoc();

//        $pfs = $project->getFiles();
//
////        $files = $pfs->allFiles();
//        if(!$pfs->exists('develop/structure.xml')){
//            throw Exception::make('Could not find structure.xml');
//        }
//        $xml = $pfs->get('develop/structure.xml');
//        $d = PhpdocStructure::deserialize($xml, 'xml');

//        $this->line($d->getFiles()[0]->toYaml());

//        $this->line( SchemaPrinter::doPrint(
//            graphql()->prepSchema()
//        ));
//
//        $doc = codex()->get('codex/master::index');
//        $content = $doc->getContent();

        $a = 'a';
    }

    public function handle234(AddonCollection $addons)
    {

        $query = '
query Fetch {
    document(projectKey: "codex", revisionKey:"master", documentKey:"index"){
        layout @assoc
    }
    codex {
        display_name
        description
        projects {
            key
            display_name
            description
            default_revision
            revisions {
                key
                default_document 
            }
        }
    }
}
';
//        $schema   = graphql()->prepSchema();
        $document = graphql()->documentAST();

        $parsed = Parser::parse($query);
        Visitor::visit($parsed, [
            'Directive' => [
                'leave' => function ($node, $key, $parent, $path, $ancestors) use ($document) {

                    $parentType = $document->objectTypeDefinition($ancestors[ 0 ]->kind);

                    /** @var \Illuminate\Support\Collection|FieldDefinitionNode[] $fields */
                    $fields = collect($parentType->fields)->keyBy(function (FieldDefinitionNode $fieldDefinitionNode) {
                        return $fieldDefinitionNode->name->value;
                    });

                    /** @var \Illuminate\Support\Collection|\GraphQL\Language\AST\FieldNode[] $ancestorFieldNodes */
                    $ancestorFieldNodes = collect($ancestors)->filter(function ($ancestor) {
                        return $ancestor instanceof FieldNode;
                    })->values();

                    $field              = $fields[ $ancestorFieldNodes[ 1 ]->name->value ];
                    $partial            = PartialParser::fieldDefinition('layout: Assoc!');
                    $parentType->fields = ASTHelper::mergeUniqueNodeList($parentType->fields, [ $partial ], true);
                    $document->setDefinition($parentType);


                    /** @var FieldDefinitionNode $fieldDef */
//                    $fieldDef         = Utils::find($document->queryTypeDefinition()->fields, function (FieldDefinitionNode $value) use ($fields) {
//                        return $value->name->value === $fields[ 0 ]->name->value;
//                    });
//                    $fieldDefTypeName = ASTHelper::getFieldTypeName($fieldDef);
//                    $parentType     = $document->objectTypeDefinition($node->kind);
//
//
//                    /** @var \GraphQL\Language\AST\FieldNode $field */
//                    $field = last($ancestors);
//                    $document->objectTypeDefinitions();
//                    $queryDef = $document->queryTypeDefinition()->fields;
//                    $fieldDef = $document->queryTypeDefinition()->fields[ 0 ];
////                    $fieldDef = $schema->getQueryType()->getField($fields[ 0 ]->name->value);
//                    $type = $fieldDef->type;
//                    if ($type instanceof WrappingType) {
//                        $wrapped     = $type->getWrappedType(true);
//                        $wrappedType = $schema->getType($wrapped->name);
//                        $subField    = $wrapped->getField($fields[ 1 ]->name->value);
//
//                        $partial      = PartialParser::fieldDefinition('layout: Assoc!');
//                        $revisionType = $schema->getType('Revision');
//                        $assocType    = $schema->getType('Assoc');
//                    }
                    // return
                    //   null: no action
                    //   Visitor::stop(): stop visiting altogether
                    //   Visitor::removeNode(): delete this node
                    //   any value: replace this node with the returned value
                    return null;
                },
            ],
        ]);
        $result = graphql()->executeQuery($parsed, null, [] //[ 'project' => 'codex', 'revision' => 'master', 'document' => 'index' ]
        );

        $a = 'a';
        $this->line(json_encode($result->data, JSON_PRETTY_PRINT));
    }

    public function introspect()
    {
        $r = graphql()->executeQuery(<<<GRAPHQL
query IntrospectionQuery {
    __schema {
      queryType { name }
      mutationType { name }
      subscriptionType { name }
      types {
        ...FullType
      }
      directives {
        name
        description
        locations
        args {
          ...InputValue
        }
      }
    }
  }

  fragment FullType on __Type {
    kind
    name
    description
    fields(includeDeprecated: true) {
      name
      description
      args {
        ...InputValue
      }
      type {
        ...TypeRef
      }
      isDeprecated
      deprecationReason
    }
    inputFields {
      ...InputValue
    }
    interfaces {
      ...TypeRef
    }
    enumValues(includeDeprecated: true) {
      name
      description
      isDeprecated
      deprecationReason
    }
    possibleTypes {
      ...TypeRef
    }
  }

  fragment InputValue on __InputValue {
    name
    description
    type { ...TypeRef }
    defaultValue
  }

  fragment TypeRef on __Type {
    kind
    name
    ofType {
      kind
      name
      ofType {
        kind
        name
        ofType {
          kind
          name
          ofType {
            kind
            name
            ofType {
              kind
              name
              ofType {
                kind
                name
                ofType {
                  kind
                  name
                }
              }
            }
          }
        }
      }
    }
  }
GRAPHQL
        );
        if (count($r->errors) > 0) {
            $this->line($r->errors[ 0 ]->getTraceAsString());
        }
        $a = 'a';
    }

    public function handle3()
    {
        $builder = new TreeBuilder(Project::class);
        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $root */
        $root = $builder->getRootNode();

        $root
            ->children()
            ->scalarNode('display_name')->defaultValue('')->end()
            ->scalarNode('disk')->defaultNull()->end();

        $config = $builder->buildTree()->finalize([]);
        $a      = 'a';
    }
}
