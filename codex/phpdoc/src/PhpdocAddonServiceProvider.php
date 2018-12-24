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
use Codex\Phpdoc\Serializer\AttributeAnnotationReader;
use Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Illuminate\Contracts\Foundation\Application;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;

class PhpdocAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-phpdoc' ];

    public $mapConfig = [
        'codex-phpdoc.default_project_config' => 'codex.projects',
    ];

    public $commands = [
//        Console\ClearPhpdocCommand::class,
//        Console\GeneratePhpdocCommand::class,
    ];

    public $bindings = [
        AttributeAnnotationReader::class => AttributeAnnotationReader::class,
        Reader::class => SimpleAnnotationReader::class
    ];

    public $aliases = [
    ];

    public function register()
    {
        $this->registerSerializer();
    }

    protected function registerSerializer()
    {
        AnnotationRegistry::registerLoader('class_exists');
        $this->app->bind(\JMS\Serializer\Serializer::class, function (Application $app) {
            return SerializerBuilder::create()
                ->addDefaultHandlers()
                ->addDefaultDeserializationVisitors()
                ->addDefaultSerializationVisitors()
                ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
                ->build();
        });
        $this->app->alias(\JMS\Serializer\Serializer::class, 'codex.serializer');
    }

    public function boot(AttributeAnnotationReader $reader)
    {
        $reader->handleClassAnnotations(PhpdocStructure::class);

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
