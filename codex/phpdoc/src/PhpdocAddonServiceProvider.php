<?php /** @noinspection StaticInvocationViaThisInspection */

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
use Codex\Hooks;
use Codex\Phpdoc\Serializer\AttributeAnnotationReader;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Codex\Phpdoc\Serializer\XmlAccessorStrategy;
use Codex\Revisions\Revision;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Illuminate\Contracts\Foundation\Application;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\XmlDeserializationVisitor;

class PhpdocAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-phpdoc', 'codex-phpdoc.layout' ];

    public $mapConfig = [
        'codex-phpdoc.default_project_config' => 'codex.projects',
        'codex-phpdoc.processors'             => 'codex.projects.processors',
    ];

    protected $assetDirs = [ 'assets' => 'codex_phpdoc' ];

    public $commands = [
        Console\PhpdocClearCommand::class,
        Console\PhpdocGenerateCommand::class,
        Console\PhpdocStatusCommand::class,
    ];

    public $bindings = [
        AttributeAnnotationReader::class => AttributeAnnotationReader::class,
        Reader::class                    => AnnotationReader::class,
    ];

    public $aliases = [];

    public $extensions = [
        Api\PhpdocSchemaExtension::class,
        Documents\PhpdocProcessorExtension::class,
    ];

    public $providers = [
        Http\HttpServiceProvider::class,
    ];

    public function register()
    {
        Hooks::register('codex.urls.map', function ($map) {
            $map[ 'phpdoc' ] = 'codex.phpdoc';
            return $map;
        });
        $config = $this->app->make('config');
//        $config->set('codex.processor-defaults.links.actions.phpdoc', PhpdocLinks::class . '@handle');
//        $config->set('codex.processor-defaults.macros.phpdoc:method', PhpdocMacros::class . '@method');
//        $config->set('codex.processor-defaults.macros.phpdoc:method:signature', PhpdocMacros::class . '@methodSignature');
//        $config->set('codex.processor-defaults.macros.phpdoc:entity', PhpdocMacros::class . '@entity');
        $this->registerRevisionMacros();
        $this->registerSerializer();
        $this->registerReact();
    }

    protected function registerReact()
    {
        Hooks::register('controller.web.view', function ($view) {
            view()->startPush('head', '<script type="text/javascript" src="' . asset('vendor/codex_phpdoc/js/phpdoc.js') . '"></script>');
            view()->startPush('init', 'app.plugin(new codex.phpdoc.default());');
        });
    }

    protected function registerRevisionMacros()
    {
        Revision::macro('phpdoc', function () {
            return $this->storage('phpdoc', function ($revision) {
                return new RevisionPhpdoc($revision);
            });
        });
        Revision::macro('isPhpdocEnabled', function () {
            return $this->attr('phpdoc.enabled', false);
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
        $registry->codex->getChild('urls')->add('phpdoc', 'string');
        $phpdoc = $registry->addGroup('phpdoc');
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
