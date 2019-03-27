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

namespace Codex\Git\Commands;

use Codex\Codex;
use Codex\Concerns\HasCallbacks;
use Codex\Exceptions\Exception;
use Codex\Git\Connection\Ref;
use Codex\Git\Contracts\ConnectionManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Symfony\Component\Finder\SplFileInfo;

class SyncGitProject implements ShouldQueue
{
    use Queueable;
    use HasCallbacks;

    /** @var \Codex\Contracts\Projects\Project */
    protected $project;

    /** @var \Codex\Codex */
    protected $codex;

    /** @var \Codex\Git\Drivers\DriverInterface */
    protected $driver;

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
    public function __construct($projectKey, $force = false)
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
        $this->driver  = $this->project->git()->connect();
        $this->sync();
    }

    protected function sync()
    {
        $git    = $this->project->git();
        $forced = $this->force ? 'forced ' : '';
        $this->log("Starting {$forced}sync for project [{$this->project}]", $this->project[ 'git' ]);
        $refs = $this->driver->getRefs($git->getOwner(), $git->getRepository());
        if ($git->skipsMinorVersions()) {
            $this->log('Skipping minor versions');
            $refs = $refs->skipMinorVersions()->concat($refs->branches());
        } elseif ($git->skipsPatchVersions()) {
            $this->log('Skipping patch versions');
            $refs = $refs->skipPatchVersions()->concat($refs->branches());
        }

        $this->driver->getZipDownloader()->cleanRootPath();

        foreach ($refs as $ref) {
            if ($git->shouldSyncRef($ref)) {
                if (false === $this->force && $this->cache->get($ref->getCacheKey()) === $ref->getHash()) {
                    $this->log("Ref [{$ref->getName()}] skipped, matches the cached hash", $ref->toArray());
                    continue;
                }
                $this->fire('git:sync:ref', compact('ref'));
//                if (null !== $this->fire('git:sync:ref', compact('ref'), true)) {
//                    $this->log("Ref [{$ref->getName()}] canceled by hook", $ref->toArray());
//                    continue;
//                }
                try {
                    $this->syncRef($ref);
                    $this->cache->forever($ref->getCacheKey(), $ref->getHash());
                    $this->log("Ref [{$ref->getName()}] synced", $ref->toArray());
                }
                catch (\Exception $e) {
                    $this->codex->getLog()->error($e->getMessage(), (array)$e);
                }
            } else {
                $this->log("Ref [{$ref->getName()}] skipped", $ref->toArray());
            }
        }
    }

    protected function syncRef(Ref $ref)
    {
        $project  = $this->project;
        $git      = $project->git();
        $download = $this->driver
            ->getZipDownloader()
            ->download($ref->getDownloadUrl());

        $pfs = $project->getFiles(); // project filesystem
        $lfs = $download->getFs(); // local filesystem

        $docsPath = $download->getExtractedPath() . \DIRECTORY_SEPARATOR . $git->getDocsPath();
        if ( ! $lfs->exists($docsPath)) {
            throw Exception::make("Docs path does not exist [{$docsPath}");
        }
        $indexFilePath = $download->getExtractedPath() . \DIRECTORY_SEPARATOR . $git->getIndexPath();
        if ( ! $lfs->exists($indexFilePath)) {
            throw Exception::make("Index file path does not exist [{$indexFilePath}");
        }

        $pfs->deleteDirectory($ref->getName());
        $pfs->makeDirectory($ref->getName());

        $files = collect($lfs->allFiles($docsPath));
        $files->each(function (SplFileInfo $file) use ($pfs, $lfs, $ref) {
            $dirPath = $file->getRelativePath();
            $pfs->makeDirectory($ref->getName() . \DIRECTORY_SEPARATOR . $dirPath);
            $pfs->put(
                $ref->getName() . \DIRECTORY_SEPARATOR . $file->getRelativePathname(),
                $lfs->get($file->getPathname())
            );
        });

        $pfs->put(
            $ref->getName() . \DIRECTORY_SEPARATOR . 'index.' . $lfs->extension($indexFilePath),
            $lfs->get($indexFilePath)
        );

        $download->clean();
    }
}
