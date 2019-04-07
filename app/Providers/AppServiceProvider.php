<?php

namespace App\Providers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    use DispatchesJobs;

    public function boot()
    {
    }

    public function register()
    {
//        $this->registerFilesystemAdapters();
    }

}
