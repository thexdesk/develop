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

use Codex\Codex;
use Codex\Contracts\Projects\Project;
use Codex\Filesystem\Copier;
use Codex\Git\Commands\SyncProject;
use Codex\Git\Config\GitSyncConfig;
use Codex\Git\Connection\Ref;
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

    public function handle(Codex $codex)
    {
        $queue = $this->option('queue');
        if ( ! $queue) {
            codex()->getLog()->useArtisan($this);
        }
        if ($this->option('all')) {
            $projects = codex()->projects()->filter->isGitEnabled();
            foreach ($projects as $project) {
                /** @var Project $project */
                $this->comment("Starting sync job for [{$project->getKey()}]" . ($queue ? ' and pushed it onto the queue.' : '. This might take a while.'));
                $this->sync($project, $queue, $this->option('force'));
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
            $this->comment("Starting sync job for [{$project}]" . ($queue ? ' and pushed it onto the queue.' : '. This might take a while.'));
            $this->sync($project, $queue, $this->option('force'));
        }
    }

    protected function sync($project, $queue = false, $force = false)
    {
        $sync = new SyncProject($project, $force);
        if ($queue) {
            $this->dispatch($sync);
        } else {
            $this->dispatchNow($sync);
        }
    }

    public static function attachConsoleTableListener()
    {
        SyncProject::onEvent('sync_ref', function (Copier $copier, Ref $ref, GitSyncConfig $sync) {
            $remote  = $sync->getRemote();
            $project = $sync->getGit()->getModel();
            $rows    = [];
            foreach ($copier->getCopied() as $item) {
                $rows[] = [
                    $item[ 'src' ],
                    '[remote]' . $item[ 'srcItem' ]->key(),
                    '[revision]' . $item[ 'destItem' ]->key(),
                ];
            }
            $this->line(' - remote: ' . $remote->getName() . ':' . $remote->getOwner() . '/' . $remote->getRepository());
            $this->line(' - revision: ' . $project->getKey() . '/' . $ref->getName());
            $this->table([
                'glob',
                'src',
                'dest',
            ], $rows);
        }, false);
    }
}
