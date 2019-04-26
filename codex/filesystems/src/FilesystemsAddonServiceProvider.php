<?php

namespace Codex\Filesystems;

use Codex\Addons\AddonServiceProvider;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Rackspace\RackspaceAdapter;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\WebDAV\WebDAVAdapter;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use OpenCloud\Rackspace;
use Sabre\DAV\Client as WebDAVClient;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;
use Superbalist\Flysystem\GoogleStorage\GoogleStorageAdapter;

class FilesystemsAddonServiceProvider extends AddonServiceProvider
{
    public $config = [ 'codex-filesystems' ];

    public $extensions = [
        FilesystemsAttributeExtension::class
    ];

    public function register()
    {
        $this->registerFilesystemAdapters();
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

    protected function rackspace($name)
    {
        $this->fsm->extend($name, function (Application $app, array $config = []) {
            $client    = new Rackspace($config[ 'url' ], $config[ 'secret' ], $config[ 'options' ]);
            $store     = $client->objectStoreService('cloudFiles', $config[ 'region' ]);
            $container = $store->getContainer('flysystem');
            $adapter   = new RackspaceAdapter($container);
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
    }

    protected function sftp($name)
    {
        $this->fsm->extend($name, function (Application $app, array $config = []) {
            $adapter   = new SftpAdapter($config);
            $flysystem = new Filesystem($adapter);
            return new FilesystemAdapter($flysystem);
        });
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
