# Server Documentation

`\Greg\Support\Server` is working with server configurations.

# Methods:

* [scriptName](#scriptName) - Get script name;
* [scriptFile](#scriptFile) - Get script file;
* [requestTime](#requestTime) - Get request time;
* [requestMicroTime](#requestMicroTime) - Get request micro time;
* [documentRoot](#documentRoot) - Get document root;
* [has](#has) - Determine if has a configuration;
* [get](#get) - Get a configuration;
* [encoding](#encoding) - Get/Set encoding;
* [timezone](#timezone) - Get/Set timezone;
* [iniAll](#iniAll) - Get all ini configurations;
* [iniGet](#iniGet) - Get an ini configuration;
* [iniSet](#iniSet) - Set an ini configuration;
* [appendIncPath](#appendIncPath) - Append to included paths;
* [prependIncPath](#prependIncPath) - Prepend to included paths;
* [resetIncPath](#resetIncPath) - Reset included paths;
* [existsInIncPaths](#existsInIncPaths) - Determine if a path exists in included paths;
* [errorsAsExceptions](#errorsAsExceptions) - Act errors as exceptions;
* [disableErrors](#disableErrors) - Disable errors;
* [restoreErrors](#restoreErrors) - Restore errors.

## method

Description.

```php
method(mixed ...$args): mixed
```

`...$args` - Arguments.

_Example:_

```php
\Greg\Support\Server::method(...$args);
```
