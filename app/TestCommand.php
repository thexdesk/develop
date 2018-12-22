<?php

namespace App;

use Codex\Addons\AddonCollection;
use Codex\Attributes\AttributeConfigBuilderGenerator;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Contracts\Projects\Project;
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

class TestCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'test';

    public function handle(AttributeDefinitionRegistry $registry, Filesystem $fs, AttributeConfigBuilderGenerator $generator)
    {
//        $this->dispatch(new MergeAttributes(codex()->getProjects()->getDefault()));

        $project  = codex()->getProject('codex');
        $revision = $project->getRevision('master');
        $document = $revision->getDocument('index');
        $content  = $document->getContent();

        $result = codex()->getApi()->executeQuery(<<<GRAPHQL
query Check {
    codex {
        default_project       
    }
    projects {
        key
    }
}
GRAPHQL
);
        if ( ! empty($result->errors)) {
            $b = 'a';
        }

        $this->line(json_encode($result->data, JSON_PRETTY_PRINT));
        $a = 'a';
    }

    public function handle234(AddonCollection $addons)
    {
//        $this->introspect();
        $codex    = codex();
        $project  = $codex->getProject('codex');
        $revision = $project->getRevision('master');
        $document = $revision->getDocument('index');
        $content  = $document->getContent();


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
