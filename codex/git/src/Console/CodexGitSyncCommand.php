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

namespace Codex\Git\Console;

use Codex\Contracts\Projects\Project;
use Codex\Git\Commands\SyncGitProject;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class CodexGitSyncCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'codex:git:sync {name? : The name of the project}
                                           {--queue : Put the sync job on the queue}
                                           {--force : Put the sync job on the queue}
                                           {--all : Sync all projects}';

    protected $description = 'Synchronise all projects that have the git addon enabled.';

    public function handle()
    {
        $codex = codex();
        if ($this->option('all')) {
            foreach ($codex->git->getProjects() as $project) {
                $this->comment("Starting sync job for [{$project->getKey()}]" . ($this->option('queue') ? ' and pushed it onto the queue.' : '. This might take a while.'));
                $this->sync($project, $this->option('queue'), $this->option('force'));
            }
        } else {
            $projects = codex()
                ->getProjects()
                ->filter(function (Project $project) {
                    return $project->git()->isEnabled();
                })
                ->transform(function (Project $project) {
                    return $project->getKey();
                })
                ->all();
            $project  = $this->argument('name') ? $this->argument('name') : $this->choice('Pick the git enabled project you wish to sync', $projects);
            $this->comment("Starting sync job for [{$project}]" . ($this->option('queue') ? ' and pushed it onto the queue.' : '. This might take a while.'));
            $this->sync($project, $this->option('queue'), $this->option('force'));
        }
    }

    protected function sync($project, $queue = false, $force = false)
    {
        $sync = new SyncGitProject($project, $force);
        if ($queue) {
            $this->dispatch($sync);
        } else {
            codex()->getLog()->useArtisan($this);
            $this->dispatchNow($sync);
        }
    }
}
