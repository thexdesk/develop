<?php

namespace Codex\Comments;

use Codex\Comments\Drivers\DisqusDriver;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Support\Manager;

class CommentsManager extends AbstractManager
{

    public function createDisqusDriver()
    {
        new DisqusDriver($this->app['config']['codex-comments']);
    }


    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return object
     */
    protected function createConnection(array $config)
    {
        // TODO: Implement createConnection() method.
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'codex-comments';
    }
}
