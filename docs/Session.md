# Session Documentation

`\Greg\Support\Session` is working with `$_SESSION`.

Uses: [`\Greg\Support\Accessor\ArrayAccessorStaticTrait`](ArrayAccessorStaticTrait.md).

# Methods:

* [reloadFlash](#reloadFlash) - Reload flash container;
* [loadFlash](#loadFlash) - Load flash container;
* [unloadFlash](#unloadFlash) - Unload flash container;
* [setFlash](#setFlash) - Set a flash value;
* [getFlash](#getFlash) - Get a flash value;
* [iniSet](#iniSet) - Set a session configuration;
* [iniGet](#iniGet) - Get a session configuration;
* [hasId](#hasId) - Determine if has session id;
* [getId](#getId) - Get session id;
* [setId](#setId) - Set session id;
* [persistent](#persistent) - Enable/disable persistent mode;
* [setName](#setName) - Set session name;
* [getName](#getName) - Get session name;
* [start](#start) - Start session;
* [unserialize](#unserialize) - Unserialize session data;
* [resetLifetime](#resetLifetime) - Reset cookie session lifetime.

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
