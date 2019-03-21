---
title: Macros
---

# Macros

## General
#### Hide
```php
<!--*codex:general:hide*-->
> This blockquote will be hidden when viewed in Codex, but visible in other (eg github) viewers.   
<!--*codex:/general:hide*-->
```


## Gists
#### Gist + scrollbar
```markdown
<!--*codex:scrollbar(200)*-->
<!--*codex:gist('10c3090294a416df4b7b459bfe914cc0')*-->
<!--*codex:/scrollbar*-->
```
<!--*codex:scrollbar(200)*-->
<!--*codex:gist('10c3090294a416df4b7b459bfe914cc0')*-->
<!--*codex:/scrollbar*-->

##### Gist + file + scrollbar
```markdown
<!--*codex:scrollbar(200)*-->
<!--*codex:gist('10c3090294a416df4b7b459bfe914cc0', 'ControlPanelServiceProvider.php')*-->
<!--*codex:/scrollbar*-->
```
<!--*codex:scrollbar(200)*-->
<!--*codex:gist('10c3090294a416df4b7b459bfe914cc0', 'ControlPanelServiceProvider.php')*-->
<!--*codex:/scrollbar*-->



## PHPDoc
#### Method Signature
```php
<!--*codex:phpdoc:method:signature('Codex\Codex::get()', true, 'namespace,tags')*-->
````
<!--*codex:phpdoc:method:signature('Codex\Codex::get()', true, 'namespace,tags')*-->


#### Method
```php
<!--*codex:phpdoc:method('Codex\Phpdoc\Documents\PhpdocMacros::method', true, true, 'namespace,tags')*-->
````
<!--*codex:phpdoc:method('Codex\Phpdoc\Documents\PhpdocMacros::method()', true, true, 'namespace,tags')*-->
