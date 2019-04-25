<?php

namespace Codex\Git\Http;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

/**
 * This is the class HttpServiceProvider.
 *
 * @package        Codex\Addon
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 *
 */
class HttpServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Codex\Git\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group([
            'prefix'    => config('codex.base_route') . '/' . config('codex-git.route_prefix', '_git-webhook'),
            'namespace' => $this->namespace,
            'as'        => 'codex.git.webhook.',
        ], function ($router)
        {
            require __DIR__ . '/routes.php';
        });
    }
}
