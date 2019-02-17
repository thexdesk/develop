<?php /** @noinspection UnusedFunctionResultInspection */

namespace Codex\Sitemap\Commands;

use Codex\Codex;
use Codex\Hooks;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap
{
    /** @var string */
    protected $path;

    public function __construct(string $path = null)
    {
        $this->path = $path ?? config('codex-sitemap.output_path', public_path('sitemap.xml'));
    }

    public function handle(Codex $codex, Sitemap $sitemap)
    {
        $sitemap->add(url()->route('codex', [], false));
        $sitemap->add(url()->route('codex.documentation', [], false));

        foreach ($codex->projects() as $project) {
            $sitemap->add($project->url(null, null, false));
            foreach ($project->revisions() as $revision) {
                $sitemap->add($revision->url(null, false));
                foreach ($revision->getDocuments()->loadable() as $key => $document) {
                    $sitemap->add($revision->url($key, false));
                }
            }
        }

        Hooks::run('codex.sitemap.generate', [ $sitemap ]);

        $sitemap->writeToFile($this->path);
    }
}
