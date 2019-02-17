---
title: Phpdoc
subtitle: Addons
---


# Phpdoc Addon

The Phpdoc Addon provides Codex the means to parse the phpdoc generated xml file and display it in a user-friendly way.


### Installation

```bash
composer require codex/phpdoc
php artisan codex:addons:enable codex/phpdoc
php artisan vendor:publish --provider="Codex\Phpdoc\PhpdocAddonServiceProvider"
```

### Configuration

...


### Examples

#### Api Viewer
Revisions with phpdoc enabled allows users to browse the [Api Viewer](#codex:phpdoc(Codex\Codex))


#### Macros
**Example**
```php
<!--*codex:phpdoc:method('Codex\Phpdoc\Documents\PhpdocMacros::method()', true, true, 'namespace,tags')*-->
````
<!--*codex:phpdoc:method('Codex\Phpdoc\Documents\PhpdocMacros::method()', true, true, 'namespace,tags')*-->


#### Links


| Example                                                                                                                      | Code                                                                        |
|:-----------------------------------------------------------------------------------------------------------------------------|:----------------------------------------------------------------------------|
|     [Class Link](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex))                                | `[Class Link](#codex:phpdoc(Codex\Codex))`                                  |
|     [Class Link](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):!styling:!icon)                 | `[Class Link](#codex:phpdoc(Codex\Codex):!styling:!icon)`                   |
|     [Class Drawer + Popover](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):drawer:popover)     | `[Class Drawer + Popover](#codex:phpdoc(Codex\Codex):drawer:popover)`       |
|     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):drawer:popover)                           | `[](#codex:phpdoc(Codex\Codex):drawer:popover)`                             |
|     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):drawer:popover:type)                      | `[](#codex:phpdoc(Codex\Codex):drawer:popover:type)`                        |
|     [Link to phpdoc class](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex))                      | `[Link to phpdoc class](#codex:phpdoc(Codex\Codex))`                        |
|     [Link to phpdoc method](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex::get()))              | `[Link to phpdoc method](#codex:phpdoc(Codex\Codex::get()))`                |
|     [Class popover](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):popover)                     | `[Class popover](#codex:phpdoc(Codex\Codex):popover)`                       |
|     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):popover)                                  | `[](#codex:phpdoc(Codex\Codex):popover)`                                    |
|     [Method popover](../../resources/docs/codex/master/addons/phpdoc.md#codex:phpdoc(Codex/Codex::get()):popover)                | `[Method popover](#codex:phpdoc(Codex\Codex::get()):popover)`               |
|     [Method popover + type](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex::get()):popover:type) | `[Method popover + :type](#codex:phpdoc(Codex\Codex::get()):popover::type)` |
| Class type:     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):type)                         | `Class type: [](#codex:phpdoc(Codex\Codex):type)`                           |
| Interface type:     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Contracts/Codex):type)           | `Interface type: [](#codex:phpdoc(Codex\Contracts\Codex):type)`             |
| Trait type:     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Concerns/HasCodex):type)             | `Trait type: [](#codex:phpdoc(Codex\Concerns\HasCodex):type)`               |
| string type:     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(string):type)                             | `String type: [](#codex:phpdoc(string):type)`                               |
| array type:     [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(array):type)                               | `Array type: [](#codex:phpdoc(array):type)`                                 |
|     [Method tooltip](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex::get()):tooltip)             | `[Method tooltip](#codex:phpdoc(Codex\Codex::get()):tooltip)`               |
|     [Method tooltip](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex::get()):tooltip)             | `[Method tooltip](#codex:phpdoc(Codex\Codex::get()):tooltip)`               |




| Class                                                                                                   | Interface                                                                                                         | Trait                                                                                                                | Code                                            |
|:--------------------------------------------------------------------------------------------------------|:------------------------------------------------------------------------------------------------------------------|:---------------------------------------------------------------------------------------------------------------------|:------------------------------------------------|
|    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex))                     |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Contracts/Codex))                     |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Concerns/Bootable))                     | `[](#codex:phpdoc(<name>))`                     |
|    [Link](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex))                 |    [Link](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Contracts/Codex))                 |    [Link](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Concerns/Bootable))                 | `[Link](#codex:phpdoc(<name>))`                 |
|    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):!styling:!icon)      |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Contracts/Codex):!styling:!icon)      |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Concerns/Bootable):!styling:!icon)      | `[](#codex:phpdoc(<name>):!styling:!icon)`      |
|    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):type:popover)        |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Contracts/Codex):type:popover)        |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Concerns/Bootable):type:popover)        | `[](#codex:phpdoc(<name>):type:popover)`        |
|    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):type:popover:drawer) |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Contracts/Codex):type:popover:drawer) |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Concerns/Bootable):type:popover:drawer) | `[](#codex:phpdoc(<name>):type:popover:drawer)` |
|    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Codex):type)                |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Contracts/Codex):type)                |    [](../../resources/docs/codex/master/processors/links.md#codex:phpdoc(Codex/Concerns/Bootable):type)                | `[](#codex:phpdoc(<name>):type:popover:drawer)` |
