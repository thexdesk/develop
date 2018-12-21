<?php

namespace App\Providers;

use App\Attributes\AttributeServiceProvider;
use App\ExtendCodexSchemaExtension;
use Codex\Addons\Extensions\RegisterExtension;
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
    }
}
