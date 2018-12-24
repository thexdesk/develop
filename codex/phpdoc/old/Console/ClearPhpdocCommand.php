<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Phpdoc\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ClearPhpdocCommand extends Command
{
    protected $signature = 'codex:phpdoc:clear';

    protected $description = 'Clear generated phpdoc';

    public function handle()
    {
        $path = config('codex-phpdoc.storage.path');
        (new Filesystem())->deleteDirectory($path);
        $this->info('Cleared generated phpdoc in '.$path);
    }
}
