<?php

namespace Codex\Phpdoc\Console;

use Codex\Contracts\Revisions\Revision;
use Illuminate\Console\Command;

class PhpdocGenerateCommand extends Command
{
    protected $signature = 'codex:phpdoc:generate {revisions?* : One or more "project/revision" to geneate } {--a|all : Generates all} {--Q|queue : Use the queue}';

    protected $description = 'Processes the structure.xml files and generates the result';

    public function handle()
    {
        $revisions = $this->argument('revisions');
        $all       = $this->option('all');
        $queue     = $this->option('queue');

        $projects = codex()->projects();
        foreach ($projects as $project) {
            $revisions = $project->revisions();
            foreach ($revisions as $revision) {
                if ( ! $revision->isPhpdocEnabled()) {
                    continue;
                }
                $this->line("{$project}/{$revision}");
            }
        }

        if ($revisions) {
            collect($revisions)->map(function ($revision) {
                return codex()->get($revision);
            })->each(function (Revision $revision) {
                if ( ! $revision->phpdoc()->isEnabled()) {
                    $this->warn("Skipping [{$revision->getProject()}/{$revision}] because it does not have phpdoc enabled");
                    return;
                }
                $generator = $revision->phpdoc()->getGenerator();
                $this->line("Generating phpdoc for {$revision->getProject()}/{$revision}");
                $generator->generate(true);
            });
            $this->info('All done sire');
        }
    }
}
