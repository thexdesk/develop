<?php


namespace Codex\Git\Commands;


use Codex\Codex;
use Codex\Concerns\HasEvents;
use Codex\Filesystem\Copier;
use Codex\Git\Config\GitSyncConfig;
use Codex\Git\Connection\Ref;
use Codex\Git\Contracts\ConnectionManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyncProject implements ShouldQueue
{
    use Queueable;
    use HasEvents;

    /** @var \Codex\Contracts\Projects\Project */
    protected $project;

    /** @var \Codex\Codex */
    protected $codex;

    /** @var \Codex\Git\Config\GitConfig */
    protected $git;

    /** @var \Illuminate\Contracts\Cache\Repository */
    protected $cache;

    /** @var bool */
    protected $force;

    /** @var string */
    protected $projectKey;

    /**
     * SyncProject constructor.
     *
     * @param      $projectKey
     * @param bool $force
     */
    public function __construct(string $projectKey, $force = false)
    {
        $this->projectKey = $projectKey;
        $this->force      = $force;
    }

    /**
     * log method.
     *
     * @param       $message
     * @param array $context
     *
     * @return mixed
     */
    public function log($message, $context = [])
    {
        $this->codex->log('info', $message, $context);

        return $message;
    }

    public function handle(Codex $codex, ConnectionManager $manager, Repository $cache)
    {
        $this->codex   = $codex;
        $this->project = $codex->getProject($this->projectKey);
        $this->cache   = $cache;
        if ($this->project->isGitEnabled()) {
            $forced = $this->force ? 'forced ' : '';
            $this->log("Starting {$forced}sync for project [{$this->project}]", $this->project[ 'git' ]);
            $this->git = $this->project->git();
            foreach ($this->git->getSyncs() as $sync) {
                $this->sync($sync);
            }
        }
    }

    public function sync(GitSyncConfig $sync)
    {
        $remote = $sync->getRemote();

        $refs = $sync->getRefs();

        if ($sync->skipsMinorVersions()) {
            $this->log('Skipping minor versions');
            $refs = $refs->skipMinorVersions()->concat($refs->branches());
        } elseif ($sync->skipsPatchVersions()) {
            $this->log('Skipping patch versions');
            $refs = $refs->skipPatchVersions()->concat($refs->branches());
        }

        foreach ($refs as $destination => $ref) {
            /** @var Ref $ref */
            if (false === $this->force && $this->cache->get($ref->getCacheKey()) === $ref->getHash()) {
                $this->log("Ref [{$this->project}/{$ref->getName()}] skipped, matches the cached hash", $ref->toArray());
                continue;
            }
            $this->log("Syncing ref [{$this->project}/{$ref->getName()}] synced", $ref->toArray());

//                $this->fireEvent('git:sync:ref', compact('ref'));
//                if (null !== $this->fire('git:sync:ref', compact('ref'), true)) {
//                    $this->log("Ref [{$ref->getName()}] canceled by hook", $ref->toArray());
//                    continue;
//                }
            try {
                $this->syncRef($sync, $ref, $destination);
                $this->cache->forever($ref->getCacheKey(), $ref->getHash());
                $this->log("Ref [{$this->project}/{$ref->getName()}] synced", $ref->toArray());
            }
            catch (\Exception $e) {
                $this->codex->getLog()->error("[{$this->project}/{$ref->getName()}] {$e->getMessage()}", (array)$e);
            }
        }
    }

    protected function syncRef(GitSyncConfig $sync, Ref $ref, $path = null)
    {
        /** @var \League\Flysystem\Filesystem $projectFs */
        /** @var \League\Flysystem\Adapter\AbstractAdapter $projectFsAdapter */

        $remote        = $sync->getRemote();
        $connection    = $remote->getConnection();
        $downloader    = $connection->getZipDownloader();
        $download      = $downloader->download($ref->getDownloadUrl());
        $extractedPath = $download->getExtractedPath();
        $projectFs     = $this->project->getDisk()->getDriver();
        $path          = $path ?: $ref->getName();
        $copier        = new Copier($extractedPath, $projectFs);

        foreach ($sync->getCopy() as $src => $dest) {
            $copier->copy($src, $dest, compact('path'));
        }

        $this->fireEvent('sync_ref', $copier, $ref, $sync);
    }

}
