<?php

namespace App\Codex\Console;

use Codex\Filesystem\Temp;
use Illuminate\Console\Command;
use Symfony\Component\VarDumper\VarDumper;
use vierbergenlars\SemVer\SemVerException;
use vierbergenlars\SemVer\version;

class BootCommand extends Command
{
    protected $signature = 'dev:boot';

    /** @var \App\Tmp */
    protected $tmp;

    /**
     * handle method
     *
     * @return void
     * @throws \Cz\Git\GitException
     */
    public function handle()
    {
        $remotes              = explode("\n", trim(`git remote`));
        $remoteFetchTagConfig = $this->git('config --local --get-regexp remote.*.fetch refs/tag')
            ->filter(function ($line) {
                $item = last(explode(' ', $line));
            })->mapWithKeys(function ($item) {
                return [ $item[ 0 ] => $item[ 1 ] ];
            })->toArray();


        $remoteFetchTagOptConfig = collect(explode("\n", trim(`git config --local --get-regexp remote.*.tagopt`)))
            ->filter(function ($line) {
                $values = explode(' ', last(explode(' ', $line)));
                /** @noinspection ExplodeMissUseInspection */
                return ! in_array('--no-tags', $values, true);
            })->keys()->toArray();

        $a = $remoteFetchTagOptConfig->whereIn('remote.origin.tagopt', '--no-tags');
        VarDumper::dump($remotes);
    }

    protected function git($cmd)
    {
        return collect(explode("\n", trim(shell_exec('git ' . $cmd))));
    }

    protected function askTag($prevTag = null)
    {
        $tag         = $this->option('tag');
        $prevVersion = null;
        if ($prevTag) {
            try {
                $prevVersion = new version($prevTag);
            }
            catch (SemVerException $e) {
                $prevVersion = null;
                $prevTag     = null;
            }
        }
        if ($tag === null && $prevVersion !== null) {
            $this->comment("Previous tag was [$prevVersion].");
            $selected = head($this->select('Select', [ 'patch', 'minor', 'major', 'custom' ]));
            if ($selected === 'custom') {
                $tag = $this->ask('Enter tag');
            } else {
                $tag = $prevVersion->inc($selected)->getVersion();
            }
        } elseif ($tag === null && $prevVersion === null) {
            $tag = $this->ask('Enter first tag', '0.1.0');
            try {
                $version = new version($tag);
            }
            catch (SemVerException $e) {
                $this->error($e->getMessage());
                return $this->askTag($prevTag);
            }
        }
        return $tag;
    }

    protected function cloneToTmp($remoteUrl, $branch)
    {
        $tmpDir = $this->makeTempDir(str_slug($remoteUrl) . '-' . $branch);
        chdir($tmpDir);
        `git clone {$remoteUrl} .`;
        `git checkout "{$branch}";`;
        return $tmpDir;
    }

    protected function makeTempDir($prefix)
    {
        $this->tmp = app()->make(Temp::class, [ 'prefix' => 'codex-git-tag-' . $prefix ]);
        $this->tmp->initRunFolder();
        $tmpDir = $this->tmp->getTmpFolder();
        return $tmpDir;
    }

}
