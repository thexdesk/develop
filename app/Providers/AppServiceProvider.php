<?php

namespace App\Providers;

use App\Attributes\AttributeServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    use DispatchesJobs;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->dispatch(new RegisterExtension(ExtendCodexSchemaExtension::class));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AttributeServiceProvider::class);


//        $transport = new AgentTransport();
////        $transport = new CurlTransport(env('STACKIFY_API_KEY'));
//        $handler   = new Handler(env('STACKIFY_APPNAME'), env('STACKIFY_ENVIRONMENT'), $transport);
////        $logger    = new Logger(env('STACKIFY_APPNAME'), env('STACKIFY_ENVIRONMENT'));
//        $log = app('log');
//        $logger = new Monolog('logger');
//        $logger->pushHandler($handler);
//        $logger->info('hai');
//        $this->app->instance('codex.log', $log = new Writer(
//            new Monolog($this->app->environment()),
//            $this->app['events']
//        ));
//        $log->setEnabled($this->config['codex.log']);
//        $log->useFiles($this->config['codex.paths.log']);
//        if (true === config('app.debug', false)) {
//            $log->useChromePHP();
//            $log->useFirePHP();
//        }

        $a = 'a';
    }
}
