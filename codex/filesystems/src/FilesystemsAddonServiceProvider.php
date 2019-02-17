<?php

namespace Codex\Filesystems;

use Codex\Addons\AddonServiceProvider;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Sabre\DAV\Client as WebDAVClient;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class FilesystemsAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-filesystems' ];

    public function register()
    {
        $this->app->booting(function () {
            $this->registerFilesystemAdapters();
        });
    }

    /** @var \Illuminate\Filesystem\FilesystemManager */
    protected $fsm;

    protected function registerFilesystemAdapters()
    {
        $this->fsm = $this->app->make('filesystem');
        $config    = $this->app[ 'config' ][ 'codex-filesystems' ];
        foreach ($config[ 'use' ] as $driver) {
            $method = camel_case($driver);
            $name   = $config[ 'driverNames' ][ $driver ];
            $this->$method($name);
        }
    }

    protected function googleCloud($name)
    {
        $this->fsm->extend($name, function (Application $app, array $config = []) {
            $storageClient = new StorageClient($config);
            $adapter       = new GoogleStorageAdapter($storageClient, $storageClient->bucket($config[ 'bucket' ]));
            $flysystem     = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
    }

    protected function zip($name)
    {
        $this->fsm->extend($name, function (Application $app, array $config = []) {
            $adapter   = new ZipArchiveAdapter($config[ 'path' ]);
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
    }

    protected function dropbox($name)
    {
        $this->fsm->extend($name, function (Application $app, array $config = []) {
            $client    = new DropboxClient($config[ 'token' ]);
            $adapter   = new DropboxAdapter($client, $config[ 'prefix' ] || '');
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
    }

    protected function webdav($name)
    {
        $this->fsm->extend($name, function (Application $app, array $config = []) {
            $client    = new WebDAVClient($config);
            $adapter   = new WebDAVAdapter($client, $config[ 'prefix' ]);
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
    }
}
