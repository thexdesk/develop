<?php

namespace Codex\Sitemap\Console;

use Codex\Sitemap\Commands\GenerateSitemap;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class GenerateSitemapCommand extends Command
{
    use DispatchesJobs;

    protected $signature = 'codex:sitemap:generate {path? : The file output path}';

    protected $description = 'Generates a sitemap.xml';

    public function handle()
    {
        $path = $this->argument('path');
        if(!$path){
            $path = config('codex-sitemap.output_path', public_path('sitemap.xml'));
        }
        $this->dispatch(new GenerateSitemap($path));
        $this->line('Generated sitemap at ' . $path);
    }
}
