<?php

namespace Codex\Phpdoc\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Laradic\Support\Byte;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpdocStatusCommand extends Command
{
    protected $signature = 'codex:phpdoc:status';

//                                                 {revisions?* : One or more "project/revision" to geneate }
//                                                 {--a|all : Generates all}
//                                                 {--f|force : Force generation}
//                                                 {--Q|queue : Use the queue}';

    protected $description = 'Provides status';

    public function handle(Filesystem $fs)
    {
        $codex   = codex();
        $headers = [ 'Revision', 'has Xml file', 'Xml Size', 'Is Generated', 'Files', 'Generated Size', 'Up to date' ];
        $rows    = [];
        foreach ($this->getAllRevisions() as $id) {
            /** @var \Codex\Contracts\Revisions\Revision $revision */
            $revision = $codex->get($id);
            $phpdoc   = $revision->phpdoc();
            $phpdoc->path();

            $hasXml         = $phpdoc->hasXmlFile();
            $isGenerated    = $phpdoc->isGenerated();
            $shouldGenerate = $phpdoc->shouldGenerate();
            $size           = null;
            $generatedSize  = null;
            $generatedFiles = null;
            if ($hasXml) {
                $size = Byte::bytes($revision->getFiles()->size($phpdoc->getXmlPath()))->asMetric()->format('mb/0');
            }
            if ($isGenerated) {
                $sizes = collect($fs->files($phpdoc->getPath()))->mapWithKeys(function ($filePath) use ($fs) {
                    $size = $fs->size($filePath);
                    return [ $filePath->getFilename() => $size ];
                });

                $generatedFiles = $sizes->count();
                $generatedSize  = Byte::bytes($sizes->values()->sum())->asMetric()->format('mb/0');
            }
            $yes    = '<info>yes</info>';
            $no     = '<fg=red;options=bold>no</>';
            $rows[] = [
                $id,
                $hasXml ? $yes : $no,
                $size,
                $isGenerated ? $yes : $no,
                $generatedFiles,
                $generatedSize,
                $shouldGenerate ? $no : $yes,
            ];
        }
        $this->table($headers, $rows);
    }

    /** @return \Codex\Contracts\Revisions\Revision[] */
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

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->consoleOutput = $output;
        $this->sections[]    = $output->section();
        $this->sections[]    = $output->section();
        return parent::run($input, $output);
    }


}
