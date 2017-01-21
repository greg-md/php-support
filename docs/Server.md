# Server Documentation

`\Greg\Support\Server` is working with server configurations.

# Methods:

* [scriptName](#scriptname) - Get script name;
* [scriptFile](#scriptfile) - Get script file;
* [requestTime](#requesttime) - Get request time;
* [requestMicroTime](#requestmicrotime) - Get request micro time;
* [documentRoot](#documentroot) - Get document root;
* [has](#has) - Determine if has a configuration;
* [get](#get) - Get a configuration;
* [encoding](#encoding) - Get/Set encoding;
* [timezone](#timezone) - Get/Set timezone;
* [iniAll](#iniall) - Get all ini configurations;
* [iniGet](#iniget) - Get an ini configuration;
* [iniSet](#iniset) - Set an ini configuration;
* [appendIncPath](#appendincpath) - Append to included paths;
* [prependIncPath](#prependincpath) - Prepend to included paths;
* [resetIncPath](#resetincpath) - Reset included paths;
* [existsInIncPaths](#existsinincpaths) - Determine if a path exists in included paths;
* [errorsAsExceptions](#errorsasexceptions) - Act errors as exceptions;
* [disableErrors](#disableerrors) - Disable errors;
* [restoreErrors](#restoreerrors) - Restore errors.

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
