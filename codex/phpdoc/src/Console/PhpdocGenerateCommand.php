<?php

namespace Codex\Phpdoc\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpdocGenerateCommand extends Command
{
    protected $signature = 'codex:phpdoc:generate 
                                                 {revisions?* : One or more "project/revision" to geneate } 
                                                 {--a|all : Generates all} 
                                                 {--f|force : Force generation} 
                                                 {--Q|queue : Use the queue}';

    protected $description = 'Processes the structure.xml files and generates the result';

    /** @var \Symfony\Component\Console\Helper\ProgressBar */
    protected $revBar;

    /** @var \Symfony\Component\Console\Output\ConsoleSectionOutput[] */
    protected $sections = [];

    /** @var \Symfony\Component\Console\Output\ConsoleOutput */
    protected $consoleOutput;

    public function handle()
    {
        $codex     = codex();
        $revisions = $this->argument('revisions');
        $all       = $this->option('all');
        $force     = $this->option('force');
        $queue     = $this->option('queue');

        if ($all) {
            $revisions = $this->getAllRevisions();
        }

        if (empty($revisions)) {
            $revisions = $this->getAllRevisions();
            if(empty($revisions)){
                return $this->warn('No phpdoc revisions found');
            }
            if (Command::hasMacro('select')) {
                $revisions = $this->select('Select revisions', $revisions, true);
            } else {
                $revisions = $this->choice('Select revisions', $revisions, null, null, true);
            }
        }

        $bar = new ProgressBar($this->sections[ 0 ], count($revisions));
        $bar->setFormat(' %message% %revision% (%current%/%max%) %elapsed:6s%/%estimated:-6s%');
        $bar->start();
        foreach ($revisions as $revision) {
            /** @var \Codex\Contracts\Revisions\Revision $revision */
            $revision = $codex->get($revision);
            if ( ! $revision->isPhpdocEnabled()) {
                $this->warn("Skipping [{$revision->getProject()}/{$revision}] because it does not have phpdoc enabled");
                continue;
            }
            $bar->setMessage('Generating');
            $bar->setMessage("{$revision->getProject()}/{$revision}", 'revision');
            $bar->display();
            $this->sections[ 1 ]->writeln(' Reading xml file...');
            $phpdoc = $revision->phpdoc();
            $phpdoc
                ->on('generate', /**
                 * @param \Codex\Phpdoc\RevisionPhpdoc                    $phpdoc
                 * @param \Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure $structure
                 */
                    function ($phpdoc, $structure) {
                        $totalFiles = count($structure->getFiles());
                        $this->sections[ 1 ]->clear(1);
                        $this->revBar = new ProgressBar($this->sections[ 1 ], $totalFiles);
                        $this->revBar->setMaxSteps($totalFiles);
                        $this->revBar->setFormat(' [%bar%] %percent:3s%% %current%/%max% -- %message% %filename%');
                        $this->revBar->setMessage("{$phpdoc->getRevision()->getProject()}/{$phpdoc->getRevision()}", 'revision');
                        $this->revBar->start();
                    })
                ->on('generated.file', /**
                 * @param \Codex\Phpdoc\RevisionPhpdoc         $phpdoc
                 * @param \SplFileObject $file
                 * @param \Codex\Phpdoc\Serializer\Phpdoc\File $pfile
                 * @param                                      $i
                 * @param                                      $total
                 */
                    function ($phpdoc, $file, $pfile,$i, $total) {
                        $filename = $pfile->getPath();
                        $this->revBar->setMessage('Generating');
                        $this->revBar->setMessage($filename, 'filename');
                        $this->revBar->advance();
                    })
                ->on('generated', /**
                 * @param \Codex\Phpdoc\RevisionPhpdoc                    $phpdoc
                 * @param \Codex\Phpdoc\Serializer\Phpdoc\PhpdocStructure $structure
                 */
                    function ($phpdoc, $structure) {
                        $this->revBar->setFormat(' [%bar%] %revision% %message%. (%max% files in %elapsed%)');
                        $this->revBar->setMessage('generated');
                        $this->revBar->finish();
                    });
            $phpdoc->generate($force);
            $bar->advance();
        }
        $bar->setFormat('%message% %max% in %elapsed%');
        $bar->setMessage('Generated');
        $bar->finish();
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
