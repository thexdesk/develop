<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author    Robin Radic
 * @license   https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc;

use Codex\Addons\AddonServiceProvider;
use Codex\Attributes\AttributeDefinitionRegistry;
use Codex\Phpdoc\Api\PhpdocSchemaExtension;
use Codex\Phpdoc\Serializer\AttributeAnnotationReader;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Codex\Phpdoc\Serializer\XmlAccessorStrategy;
use Codex\Revisions\Revision;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Illuminate\Contracts\Foundation\Application;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\XmlDeserializationVisitor;

class PhpdocAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-phpdoc' ];

    public $mapConfig = [
        'codex-phpdoc.default_project_config' => 'codex.projects',
    ];

    public $commands = [
//        Console\ClearPhpdocCommand::class,
        Console\PhpdocGenerateCommand::class,
    ];

    public $bindings = [
        AttributeAnnotationReader::class => AttributeAnnotationReader::class,
        Reader::class                    => AnnotationReader::class,
    ];

    public $aliases = [
    ];

    public $extensions = [
        PhpdocSchemaExtension::class,
    ];

//    public $listen = [
//        \Codex\Revisions\Events\ResolvedRevision::class => [
//
//        ]
//    ]

    public function register()
    {
        $this->registerRevisionMacros();
        $this->registerSerializer();
    }

    protected function registerRevisionMacros()
    {
        Revision::macro('phpdoc', function ($remake = false) {
            /** @var Revision $revision */
            $revision = $this;
            $storage  = $revision->getStorage();
            if ($remake || ! $storage->has('phpdoc')) {
                $storage->put('phpdoc', app()->make(RevisionPhpdoc::class, compact('revision')));
            }
            return $storage->get('phpdoc');
        });
        Revision::macro('isPhpdocEnabled', function () {
            /** @var Revision $revision */
            $revision = $this;
            return $revision->attr('phpdoc.enabled', false);
        });
    }

    protected function registerSerializer()
    {
        AnnotationRegistry::registerLoader('class_exists');
        $this->app->bind(\JMS\Serializer\Serializer::class, function (Application $app) {
            $xmlDesVis = new XmlDeserializationVisitor(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()), new XmlAccessorStrategy());
            return SerializerBuilder::create()
                ->addDefaultHandlers()
                ->configureHandlers(function (HandlerRegistryInterface $registry) {
                    $registry->registerSubscribingHandler(new Serializer\Handler\LaravelCollectionHandler());
                })
                ->setPropertyNamingStrategy(new CamelCaseNamingStrategy())
                ->addDefaultDeserializationVisitors()
                ->addDefaultSerializationVisitors()
                ->setDeserializationVisitor('xml', $xmlDesVis)
                ->build();
        });
        $this->app->alias(\JMS\Serializer\Serializer::class, 'codex.serializer');
    }

    public function boot(AttributeDefinitionRegistry $registry, AttributeAnnotationReader $reader)
    {
//        $codex = $registry->codex->getChild('urls')->add('phpdoc', '')
        $phpdoc = $registry->addGroup('phpdoc');
//        $reader->handleClassAnnotations(Serializer\Phpdoc::class, $phpdoc);
//        $phpdoc->addChild($reader->handleClassAnnotations(Serializer\Phpdoc::class));
//        $reader->handleClassAnnotations(Manifest::class,$phpdoc);
        $phpdoc->addChild($reader->handleClassAnnotations(PhpdocStructure::class));

        $projects = $registry->projects;
        $phpdoc   = $projects->add('phpdoc', 'dictionary')->setApiType('PhpdocConfig', [ 'new' ]);
        $phpdoc->add('enabled', 'boolean'); // => false,
        $phpdoc->add('document_slug', 'string'); // => 'phpdoc',
        $phpdoc->add('title', 'string'); // => 'Api Documentation',
        $phpdoc->add('xml_path', 'string'); // => 'structure.xml',
        $phpdoc->add('doc_path', 'string'); // => '_phpdoc',
        $phpdoc->add('doc_disabled_processors', 'array.scalarPrototype'); // => [ 'header', 'toc' ], //'button',
        $phpdoc->add('view', 'string'); // => 'codex-phpdoc::document',
        $phpdoc->add('layout', 'dictionary', 'Layout'); // => require __DIR__ . '/codex-phpdoc.layout.php',
        $phpdoc->add('default_class', 'string'); // => null,

        $registry->revisions->addInheritKeys('phpdoc');
    }

}
//{
//    protected const KEY = 'phpdoc';
//    protected const PREFIX = 'codex.'.self::KEY;
//
//    protected $project = 'codex-phpdoc.default_project_config';
//
//    protected $revisionInherits = [self::KEY];
//
//    protected $configFiles = ['codex-'.self::KEY];
//
//    protected $assetDirs = ['assets' => 'codex_'.self::KEY];
//
//    protected $providers = [Http\HttpServiceProvider::class];
//
//    protected $findCommands = ['Console'];
//
//    protected $extend = [
//        \Codex\Codex::class => [self::KEY => Contracts\Phpdoc::class],
//        \Codex\Revision::class => [self::KEY => Contracts\PhpdocRevision::class],
//        \Codex\Project::class => [self::KEY => Contracts\PhpdocProject::class],
//    ];
//
//    public $bindings = [
//        self::PREFIX => Phpdoc::class,
//        self::PREFIX.'.generator' => Generator::class,
//        self::PREFIX.'.project' => PhpdocProject::class,
//        self::PREFIX.'.revision' => PhpdocRevision::class,
//    ];
//
//    protected $aliases = [
//        self::PREFIX => Contracts\Phpdoc::class,
//        self::PREFIX.'.generator' => Contracts\Generator::class,
//        self::PREFIX.'.project' => Contracts\PhpdocProject::class,
//        self::PREFIX.'.revision' => Contracts\PhpdocRevision::class,
//    ];
//
//    public function booted()
//    {
//        // no route, just add assets
//        $this->hook('controller:spa:assets', function (CodexSPAController $controller, Theme $theme) {
//            $theme
//                ->addJavascript('phpdoc', 'vendor/codex_phpdoc/js/phpdoc.chunk.js', ['core'])
//                ->addJavascript('phpdoc.runtime', 'vendor/codex_phpdoc/js/runtime~phpdoc.js', ['phpdoc'])
//                ->addStylesheet('phpdoc', 'vendor/codex_phpdoc/css/phpdoc_phpdoc.css', ['core']);
//        });
//    }
