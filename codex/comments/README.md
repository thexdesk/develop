---
title: Comments
subtitle: Addons
---

# Comments Addon

Generates a comments.xml


### Installation

```bash
composer require codex/comments
php artisan codex:addons:enable codex/comments
php artisan vendor:publish --provider="Codex\Comments\CommentsAddonServiceProvider"
```

### Configuration

**config/codex-comments.php**
```php
[
    'output_path' => public_path('comments.xml'),
]
```



<!--*codex:general:hide*-->
## Copyright/License
Copyright 2019 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](LICENSE.md)
<!--*codex:/general:hide*-->