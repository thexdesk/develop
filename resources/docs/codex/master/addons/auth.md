---
title: Auth
subtitle: Addons
---


# Auth

Provides authentication using oauth providers to restrict project access.    

### Installation

```bash
composer require codex/auth
php artisan codex:addons:enable codex/auth
php artisan vendor:publish --provider="Codex\Auth\AuthAddonServiceProvider"
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