<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc\Console;

use Codex\Phpdoc\Contracts\PhpdocRevision;
use Codex\Phpdoc\Events\GeneratorEvent;
use Codex\Phpdoc\Generator;
use Codex\Project;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GeneratePhpdocCommand extends Command
{
    protected $signature = 'codex:phpdoc:generate {revisions?* : One or more "project/revision" to geneate } {--a|all : Generates all} {--Q|queue : Use the queue} {--i|interactive : Instead of using options, ask which projects/revisions you want to generate}';

    protected $description = 'Processes the structure.xml files and generates the result';

    public function handle()
    {
        $all = $this->option('all');
        $interactive = $this->option('interactive');
        $queue = $this->option('queue');
        /** @var \Codex\Phpdoc\Contracts\PhpdocRevision[] $revisions */
        $revisions = $this->argument('revisions');

        if ($all) {
            $revisions = $this->getAll();
        } elseif ($interactive) {
            $revisions = $this->getInteractive();
        } else {
            $revisions = array_map(function ($name) {
                $name = explode('/', $name);
                if (false === codex()->hasProject($name[0])) {
                    return $this->error('Could not find project '.$name[0]);
                }
                $project = codex()->getProject($name[0]);
                if (false === $project->hasRevision($name[1])) {
                    return $this->error('Could not find revision '.$name[1].' for project '.$name[0]);
                }

                return $project->getRevision($name[1])->phpdoc;
            }, $revisions);
        }

        $this->listenToGeneratorEvents();
        $fs = new Filesystem();
        foreach ($revisions as $key => $revision) {
            $fs->deleteDirectory($revision->getDestinationPath());
            $queue ? $this->info("Adding {$key} to the queue") : $this->info("Generating {$revision->getRevision()->getProject()}/{$revision->getRevision()}");
            $revision->generate($queue);
        }
    }

    protected function listenToGeneratorEvents()
    {
        app('events')->listen(GeneratorEvent::class, function (GeneratorEvent $event) {
            $name = Generator::FLAG_PROJECT === $event->getFlag() ? 'project' :
                Generator::FLAG_MANIFEST === $event->getFlag() ? 'manifest' :
                    Generator::FLAG_FILES === $event->getFlag() ? 'files' : null;

            if ($event->equals(GeneratorEvent::START())) {
                $this->line("Started generator for PHPDoc <info>{$event->getGenerator()->getPhpdocStructure()->getTitle()}</info>");
            } elseif ($event->equals(GeneratorEvent::GENERATE())) {
                $this->line("Generating <info>{$name}</info> <comment>{$event->getContext()}</comment>");
            } elseif ($event->equals(GeneratorEvent::GENERATED())) {
                $this->line("Generated <info>{$name}</info> <comment>{$event->getContext()}</comment>");
            } elseif ($event->equals(GeneratorEvent::END())) {
                $this->line("Started generator for PHPDoc <info>{$event->getGenerator()->getPhpdocStructure()->getTitle()}</info>");
            }
        });
    }

    /**\
     * getAll method
     *
     * @return \Codex\Phpdoc\Contracts\PhpdocRevision[]
     */
    protected function getAll()
    {
        /** @var \Codex\Phpdoc\Contracts\PhpdocRevision[] $revisions */
        $revisions = [];
        codex()->getProjects()->toLaravelCollection(true)->each(function (Project $project) use (&$revisions) {
            foreach ($project->phpdoc->getRevisions() as $revision) {
                $revisions[$revision->getRevision()->getProject()->getKey().'/'.$revision->getRevision()->getKey()] = $revision;
            }
        });

        return $revisions;
    }

    protected function getInteractive()
    {
        /** @var \Codex\Phpdoc\Contracts\PhpdocRevision[] $revisions */
        $revisions = [];
        /** @var string[] $projects */
        $projects = $this->choice('Select the projects', codex()->getProjects()->keys(), null, null, true);
        foreach ($projects as $key) {
            $project = codex()->getProject($key);
            $phpdocRevisions = collect($project->phpdoc->getRevisions())
                ->transform(function (PhpdocRevision $revision) {
                    return $revision->getRevision()->getKey();
                })->toArray();
            /** @var string[] $revs */
            $revs = $this->choice('Select the projects', $phpdocRevisions, null, null, true);
            foreach ($revs as $rev) {
                $phpdocRevision = $project->getRevision($rev)->phpdoc;
                $revisions[$project->getKey().'/'.$phpdocRevision->getRevision()->getKey()] = $phpdocRevision;
            }
        }

        return $revisions;
    }
}
