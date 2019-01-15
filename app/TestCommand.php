<?php

namespace App;

use Codex\Addons\AddonCollection;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Attributes\AttributeSchemaGenerator;
use Codex\Contracts\Projects\Project;
use GraphQL\Executor\ExecutionResult;
use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\FieldNode;
use GraphQL\Language\Parser;
use GraphQL\Language\Visitor;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Nuwave\Lighthouse\Schema\AST\ASTHelper;
use Nuwave\Lighthouse\Schema\AST\PartialParser;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Yaml\Yaml;

class TestCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'test';

    public function handle()
    {
        $codex     = codex();
        $projects  = $codex->getProjects();
        $project   = $projects->get('codex');
        $revisions = $project->getRevisions();
//        $revision  = $revisions->get('master');
        $revision  = $revisions->get('master');
        $documents = $revision->getDocuments();
        $document  = $documents->get('processors/toc');
        $content   = $document->getContent();

$this->handle234234();
        return $content;
    }

    public function handle234234()
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
        $result        = codex()->getApi()->executeBatchedQueries([
            [ 'query' => $projectQuery ],
            [ 'query' => $revisionQuery ],
            [ 'query' => $documentQuery ],
        ]);
        $data          = array_map(function (ExecutionResult $result) {
            return $result->data;
        }, $result);
        $a             = 'a';
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
