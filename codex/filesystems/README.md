---
title: Filesystems
subtitle: Addons
---

# Filesystems Addon

Adds a collection of common filesystem adapters.
These can be used by your projects.


### Installation

```bash
composer require codex/filesystems
php artisan codex:addons:enable codex/filesystems
```

### Configuration

**[project]/config.php**
```php
[
    // ...
    'disk' => 'my-dropbox-project',
    // ...
];
```

**config/filesystems.php**
```php
[
    'my-webdav-project' => [
        'driver'   => 'webdav',
        'root'     => 'test-dav-project',
        'baseUri'  => env('STACK_URI'),
        'proxy'    => env('STACK_PROXY'),
        'userName' => env('STACK_USERNAME'),
        'password' => env('STACK_PASSWORD'),
        'prefix'   => env('STACK_PREFIX', ''),
    ],

    'my-google-project' => [
        'driver'    => 'google-cloud',
        'projectId' => '',
        'bucket'    => '',
    ],

    'my-dropbox-project' => [
        'driver' => 'dropbox',
        'prefix' => env('DROPBOX_PREFIX', ''),
        'token'  => env('DROPBOX_TOKEN'),
    ],

    'my-zip-project' => [
        'driver' => 'zip',
        'path'   => resource_path('docs/test-zip-project/test-zip-project.zip'),
    ],


    'my-s3-project' => [
        'driver' => 's3',
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url'    => env('AWS_URL'),
    ], 
]
```

## License

MIT