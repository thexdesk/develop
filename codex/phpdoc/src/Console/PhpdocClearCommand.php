<?php

namespace Codex\Phpdoc\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpdocClearCommand extends Command
{
    protected $signature = 'codex:phpdoc:clear 
                                                 {revisions?* : One or more "project/revision" to clear } 
                                                 {--a|all : Clears all}';

    protected $description = 'Clears the generated phpdoc files';

    public function handle()
    {
        $codex     = codex();
        $revisions = $this->argument('revisions');
        $all       = $this->option('all');

        if ($all) {
            $revisions = $this->getAllRevisions();
        }

        if (empty($revisions)) {
            if (Command::hasMacro('select')) {
                $revisions = $this->select('Select revisions', $this->getAllRevisions(), true);
            } else {
                $revisions = $this->choice('Select revisions', $this->getAllRevisions(), null, null, true);
            }
        }

        foreach ($revisions as $revision) {
            /** @var \Codex\Contracts\Revisions\Revision $revision */
            $revision = $codex->get($revision);
            if ( ! $revision->isPhpdocEnabled()) {
                $this->warn("Skipping [{$revision}] because it does not have phpdoc enabled");
                continue;
            }
            $phpdoc = $revision->phpdoc();
            $phpdoc->clear();
            $this->line("Cleared [{$revision}]");
        }
        $this->line('All done');
    }

    /** @return string[] */
    protected function getAllRevisions()
    {
        $all      = [];
        $projects = codex()->projects();
        foreach ($projects as $project) {
            $revisions = $project->revisions();
            foreach ($revisions as $revision) {
                if ( ! $revision->isPhpdocEnabled()) {
                    continue;
                }
                $all[] = "{$project}/{$revision}";
            }
        }
        return $all;
    }
}
