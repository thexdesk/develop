<?php

namespace App;

use Closure;
use Codex\Addons\AddonCollection;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeSchemaGenerator;
use Codex\Blog\Categories\Commands\FindCategories;
use Codex\Blog\Categories\Commands\ResolveCategory;
use Codex\Comments\CommentsManager;
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

class TestCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'test';

    public function handle()
    {
        $codex     = codex();

//        $comments = resolve(CommentsManager::class);
//        $disqus = $comments->connection('disqus');


//        $blog = $codex->getBlog();
//        $categories = $this->dispatch(new FindCategories($blog));
//        $category = $this->dispatch(new ResolveCategory($blog, head($categories)));

        $projects  = $codex->getProjects();
        $project   = $projects->get('codex');
        $revisions = $project->getRevisions();
        $revision  = $revisions->get('master');
        $documents = $revision->getDocuments();
//        $document  = $documents->get('getting-started/core-concepts');
        $document          = $documents->get('processors/macros');
//        $processorsEnabled = $project->attr('processors.enabled');
//        $buttons           = $document->attr('processors.buttons');
//        $attrs             = $document->setHidden([])->toArray();
        $content           = $document->render();

        return $this->line($content);
    }

    public function han123123dle()
    {
        $config   = config('codex', []);
        $registry = new DefinitionRegistry();
        $codex    = $registry->codex;
        $codex->child('changes', 'array', []);
        $cache = $codex->child('cache', 'array')->api('CacheConfig', [ 'new' ]);
        $cache->child('enabled', 'boolean');
        $cache->child('key', 'string');
        $cache->child('minutes', 'integer');

        $codex->child('display_name', 'string', 'Codex');
        $codex->child('description', 'string', '');
        $codex->child('default_project', 'string')->api('ID');

        foreach ($registry->keys() as $name) {
            $group     = $registry->getGroup($name);
            $processor = new ConfigProcessor();
            $config    = $processor->process($group, $config);
        }

        $def = new Definition();

        $def->child('default_attributes', 'array')
            ->validation(Definition::rule()->array())
            ->default([])
            ->api('DefaultAttributes', [ 'new' ]);

        $def->child('attributes', 'array')
            ->validation(Definition::rule()->array());

        $def->child('names', 'array', '[String]')
            ->default([ 'a', 'b', 'c' ])
            ->validation('array', 'string');

        $def->child('test', 'string', '[String]')
            ->default('%default_attributes.label%')
            ->validation('string');


        $processor = new ConfigProcessor();
        $c         = $processor->process($def, [
            'default_attributes' => [
                'label' => 'asdf',
            ],
            'attributes'         => [
                'text' => '%default_attributes.label%',
            ],
        ]);
    }

    protected function toArr($str)
    {
        $str = "DATA = {{$str}};";
        // gather WebFontConfig arrays
        $webfonts = preg_match_all('/(DATA\s*?=\s*?)\{(.+?)(\};)/s', $str, $matches, PREG_SET_ORDER);

        foreach ($matches as $founddata)
        {
            $original = $founddata[0];

            $WFCVariable = $founddata[1];

            // leave outer braces only
            $usable = str_replace($WFCVariable, '', $original);
            $usable = trim($usable, ';');

            // transform keys into double-quoted keys
            $usable = preg_replace('/(\w+)(:\s*?)(\{|\[)/im', '"$1"$2$3', $usable);

            // prepare to transform array wrapping single quotes to double quotes
            $lookups = array(
                '/(\[)(\s*?)(\')/',
                '/(\')(\s*?)(\])/'
            );

            $replace = array(
                '$1$2"',
                '"$2$3'
            );

            $usable = preg_replace($lookups, $replace, $usable);

            // decode
            $jsoned = json_decode($usable);

            // and check
        }
    }
    function json_decode_nice($json, $assoc = TRUE){
        $json = str_replace(array("\n","\r"),"\\n",$json);
        $json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
        $json = preg_replace('/(,)\s*}$/','}',$json);
        $json = preg_replace('/([{,]+.*)\s*:\s*\'(.*?)\'/','$1: "$3"',$json);
        $data= json_decode($json,$assoc,512);
        return $data;
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


interface DefVisitor
{
    public function visit(Definition $def);

    public function depart(Definition $def);
}

class DefWalker
{
    public function walk(Definition $def, DefVisitor $visitor)
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

    public function visit(Definition $def)
    {
        if ($def->validation) {
//            $this->getValidator()->validate()
        }
    }

    public function depart(Definition $def)
    {
        // TODO: Implement depart() method.
    }
}

/**
 * @method $this default($value)
 * @method $this parent(Definition $value)
 * @method $this name($value)
 * @method $this normalize(callable $value)
 * @method $this finalize(callable $value)
 * @method $this noApi(bool $value = true)
 * @property string                                            $name
 * @property string                                            $type
 * @property array                                             $rules
 * @property array                                             $api
 * @property \Illuminate\Support\Collection|array|Definition[] $children
 * @property Definition|null                                   $parent
 * @property boolean                                           $noApi
 * @property callable|null                                     $normalize
 * @property callable|null                                     $finalize
 * @property mixed                                             $default
 */
class Definition extends Fluent
{
    const MIXED = 'mixed';
    const STRING = 'string';
    const BOOLEAN = 'boolean';
    const INTEGER = 'integer';
    const ARRAY = 'array';

    public static $apiTypeMap = [
        self::MIXED   => 'Mixed',
        self::STRING  => 'String',
        self::BOOLEAN => 'Boolean',
        self::INTEGER => 'Int',
        self::ARRAY   => 'Assoc',
    ];

    public static function toApiType(string $type)
    {
        return array_key_exists($type, static::$apiTypeMap) ? static::$apiTypeMap[ $type ] : 'Mixed';
    }

    public function __construct($parent = null)
    {
        $children = new Collection();
        parent::__construct(array_merge(compact('parent', 'children'), []));
        $this
            ->parent($parent)
            ->name('root')
            ->type('array')
            ->validation()
            ->api('Mixed');
    }

    public function type($value)
    {
        if ( ! $this->api) {
            $this->api(static::toApiType($value));
        }
        $this->attributes[ 'type' ] = $value;
        return $this;
    }

    public function end()
    {
        return $this->parent ?? $this;
    }

    /**
     * @param array|Rule|null $value
     * @param array|Rule|null $children
     *
     * @return $this
     */
    public function validation($value = null, $children = null)
    {
        $this->attributes[ 'rules' ] = [
            'value'    => $this->getValidationValue($value),
            'children' => $this->getValidationValue($children),
        ];
        return $this;
    }

    /** @param array|Rule|string|null $value */
    protected function getValidationValue($value)
    {
        if ($value instanceof Rule) {
            $value = $value->get();
        }
        if (is_string($value)) {
            $value = explode('|', $value);
        }
        return Arr::wrap($value);
    }

    public function child($name, $type, $default = null, $apiType = null)
    {
        if ( ! $this->children->has($name)) {
            $this->children->put($name, with(new static($this))->name($name)->type($type));
        }
        /** @var static $child */
        $child = $this->children->get($name);
        if ($default) {
            $child->default($default);
        }
        if ($apiType) {
            $child->api($apiType);
        }
        return $child;
    }

    public function toArray()
    {
        $children = $this->children->toArray();
        return array_merge(parent::toArray(), compact('children'));
    }

    /**
     * api method
     *
     * @param string|array $type
     * @param array|null   $options
     *
     * @return $this
     */
    public function api($type, array $options = [])
    {
        if (is_array($type)) {
            $this->attributes[ 'api' ] = $type;
        } else {
            $this->attributes[ 'api' ] = compact('type', 'options');
        }
        return $this;
    }

    public function getPath()
    {
        $segments = [$this->name];
        $parent = $this->parent;
        while($parent){
            $segments[]=$parent->name;
            $parent=$parent->parent;
        }
        return implode('.',array_reverse($segments));
    }

    public function hasParent()
    {
        return $this->parent !== null;
    }

    public function hasChild($name)
    {
        return $this->children->has($name);
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

/**
 * @method $this inheritKeys(array $value)
 * @method $this mergeKeys(array $value)
 * @property array $inheritKeys
 * @property array $mergeKeys
 */
class DefinitionGroup extends Definition
{

}

/**
 * @property-read DefinitionGroup $codex
 * @property-read DefinitionGroup $projects
 * @property-read DefinitionGroup $revisions
 * @property-read DefinitionGroup $documents
 */
class DefinitionRegistry
{
    /** @var DefinitionGroup[] */
    protected $groups = [];

    public function __construct()
    {
        $codex     = $this->addGroup('codex');
        $projects  = $this->addGroup('projects')->parent($codex);
        $revisions = $this->addGroup('revisions')->parent($projects);
        $documents = $this->addGroup('documents')->parent($revisions);
    }

    public function addGroup(string $name)
    {
        return $this->groups[ $name ] = with(new DefinitionGroup())->name($name);
    }

    public function keys()
    {
        return array_keys($this->groups);
    }

    public function getGroup(string $name)
    {
        return $this->groups[ $name ];
    }

    /**
     * Returns the group after ensuring all the attributes that should inherit and merge are copied from the parent
     *
     * @param string $name
     *
     * @return \App\DefinitionGroup
     */
    public function resolveGroup(string $name)
    {
        $group = $this->getGroup($name);
        if ( ! $group->hasParent()) {
            return $group;
        }
        $parent = $group->parent;
        foreach (array_merge($group->inheritKeys, $group->mergeKeys) as $sourceKey => $targetKey) {
            if (is_int($sourceKey)) {
                $sourceKey = $targetKey;
            }
            if ( ! $parent->children->has($sourceKey) || $group->children->has($targetKey)) {
                continue;
            }
            $source = $parent->children->get($sourceKey);
            $this->addSourceToTarget($group, $targetKey, $source);
        }
        return $group;
    }

    protected function addSourceToTarget(Definition $target, $targetKey, Definition $source)
    {
        $targetChild = $target
            ->child($targetKey, $source->type)
            ->api($source->api)
            ->default($source->default)
            ->noApi($source->noApi);

        foreach ($source->children as $child) {
            $this->addSourceToTarget($targetChild, $child->name, $child);
        }
    }

    /** @noinspection MagicMethodsValidityInspection */
    public function __get($key)
    {
        if (array_key_exists($key, $this->groups)) {
            return $this->getGroup($key);
        }
    }

}

class ConfigNode
{
    /** @var \App\Definition */
    protected $definition;

    public function __construct(Definition $definition)
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

        $value = $this->callOnChildren($value, function (ConfigNode $childNode, $childValue, &$value) {
            $value[ $childNode->getName() ] = $childNode->normalize($childValue);
        });

        return $value;
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

        $value = $this->callOnChildren($value,
            function (ConfigNode $childNode, $childValue, &$value) {
                $value[ $childNode->getName() ] = $childNode->finalize($childValue);
            },
            function (ConfigNode $childNode, $childValue, &$value) {
                $value[ $childNode->getName() ] = $childNode->finalize($childValue);
            });

        $this->validate($value);

        return $value;
    }

    protected function callOnChildren($value, callable $onChildCb, callable $onNotExistChildCb = null)
    {

        foreach ($value as $childKey => $childValue) {

        }
        foreach ($this->definition->children as $childDefinition) {
            $childNode  = $childDefinition->createConfigNode();
            $childValue = null;
            if (array_key_exists($childDefinition->name, $value)) {
                $childValue = $value[ $childDefinition->name ];
            }
            if (array_key_exists($childDefinition->name, $value) || $childNode->hasDefault()) {
                $onChildCb($childNode, $childValue, $value);
            } else {
                $onNotExistChildCb($childNode, $childValue, $value);
            }
        }
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


    protected function diff_recursive($array1, $array2)
    {
        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if ( ! isset($array2[ $key ])) {
                    $difference[ $key ] = $value;
                } elseif ( ! is_array($array2[ $key ])) {
                    $difference[ $key ] = $value;
                } else {
                    $new_diff = $this->diff_recursive($value, $array2[ $key ]);
                    if ($new_diff != FALSE) {
                        $difference[ $key ] = $new_diff;
                    }
                }
            } elseif ( ! array_key_exists($key, $array2) || $array2[ $key ] != $value) {
                $difference[ $key ] = $value;
            }
        }
        if ( ! isset($difference)) {
            return 0;
        }
//        if (is_int(head(array_keys($difference)))) {
//            $difference = array_values($difference);
//        }
        return $difference;
    }
}

class ConfigProcessor
{
    public function process(Definition $definition, array $config = [])
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
    public function __construct(\App\DefinitionRegistry $registry)
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


