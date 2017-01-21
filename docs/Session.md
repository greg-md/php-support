# Session Documentation

`\Greg\Support\Session` is working with `$_SESSION`.

Uses: [`\Greg\Support\Accessor\ArrayAccessorStaticTrait`](ArrayAccessorStaticTrait.md).

# Methods:

* [reloadFlash](#reloadflash) - Reload flash container;
* [loadFlash](#loadflash) - Load flash container;
* [unloadFlash](#unloadflash) - Unload flash container;
* [setFlash](#setflash) - Set a flash value;
* [getFlash](#getflash) - Get a flash value;
* [iniSet](#iniset) - Set a session configuration;
* [iniGet](#iniget) - Get a session configuration;
* [hasId](#hasid) - Determine if has session id;
* [getId](#getid) - Get session id;
* [setId](#setid) - Set session id;
* [persistent](#persistent) - Enable/disable persistent mode;
* [setName](#setname) - Set session name;
* [getName](#getname) - Get session name;
* [start](#start) - Start session;
* [unserialize](#unserialize) - Unserialize session data;
* [resetLifetime](#resetlifetime) - Reset cookie session lifetime.

## method

Description.

```php
method(mixed ...$args): mixed
```

`...$args` - Arguments.

_Example:_

```php
\Greg\Support\Session::method(...$args);
```
