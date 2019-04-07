<?php

namespace App\Codex;

use App\Codex\Console\BootCommand;
use App\Codex\Console\ComposerJsonCommand;
use App\Codex\Console\DotenvSetKeyCommand;
use App\Codex\Console\TagCommand;
use App\Codex\Console\ToolboxCommand;
use Illuminate\Support\ServiceProvider;
use Jackiedo\DotenvEditor\DotenvEditorServiceProvider;

class CodexServiceProvider extends ServiceProvider
{
    public function provides()
    {
        return [
            'command.dotenv.setkey',
            'command.app.codex.toolbox',
            'command.app.codex.tag',
            'command.app.codex.boot',
            'command.app.codex.composerjson',
            ];
    }

    public function register()
    {
        $this->app->register(DotenvEditorServiceProvider::class);

        $this->app->singleton('command.dotenv.setkey', DotenvSetKeyCommand::class);
        $this->app->bind('command.app.codex.toolbox', ToolboxCommand::class);
        $this->app->bind('command.app.codex.tag', TagCommand::class);
        $this->app->bind('command.app.codex.boot', BootCommand::class);
        $this->app->bind('command.app.codex.composerjson', ComposerJsonCommand::class);

        $this->commands([
            'command.dotenv.setkey',
            'command.app.codex.toolbox',
            'command.app.codex.tag',
            'command.app.codex.boot',
            'command.app.codex.composerjson',
        ]);
    }

}
