<?php

namespace App\Providers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Sabre\DAV\Client as WebDAVClient;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;


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

    protected function registerFilesystemAdapters()
    {
        $fsm = $this->app->make('filesystem');
        $fsm->extend('webdav', function (Application $app, array $config = []) {
            $client    = new WebDAVClient($config);
            $adapter   = new WebDAVAdapter($client, $config[ 'prefix' ]);
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
        $fsm->extend('dropbox', function (Application $app, array $config = []) {
            $client    = new DropboxClient($config[ 'token' ]);
            $adapter   = new DropboxAdapter($client, $config[ 'prefix' ] || '');
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
        $fsm->extend('zip', function (Application $app, array $config = []) {
            $adapter   = new ZipArchiveAdapter($config[ 'path' ]);
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
        $fsm->extend('google-cloud', function (Application $app, array $config = []) {
            $storageClient = new StorageClient($config);
            $adapter       = new GoogleStorageAdapter($storageClient, $storageClient->bucket($config[ 'bucket' ]));
            $flysystem     = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
    }

    public function register2()
    {
//        $this->app->register(AttributeServiceProvider::class);
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
