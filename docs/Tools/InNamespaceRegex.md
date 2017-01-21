# InNamespaceRegex Documentation

`\Greg\Support\Tools\InNamespaceRegex` generate a regular expression to search in desired namespaces. Ex: `{{ Find Me! }}`.

# Methods:

* [setIn](#setin) - Set namespace;
* [getIn](#getin) - Get namespace;
* [setStart](#setstart) - Set start namespace;
* [getStart](#getstart) - Get start namespace;
* [setEnd](#setend) - Set end namespace;
* [getEnd](#getend) - Get end namespace;
* [disableInQuotes](#disableinquotes) - Disable in quotes;
* [disableIn](#disablein) - Disable in namespaces;
* [recursive](#recursive) - Enable/Disable recursive mode;
* [isRecursive](#isrecursive) - Determine if regex search recursively;
* [setRecursiveGroup](#setrecursivegroup) - Set recursive group;
* [getRecursiveGroup](#getrecursivegroup) - Get recursive group;
* [capture](#capture) - Enable/Disable capture;
* [isCaptured](#iscaptured) - Determine if regex will capture string;
* [setCapturedKey](#setcapturedkey) - Set captured key;
* [getCapturedKey](#getcapturedkey) - Get captured key;
* [allowEmpty](#allowempty) - Enable/Disable empty;
* [isAllowedEmpty](#isallowedempty) - Determine if is allowed empty;
* [setMatch](#setmatch) - Set match;
* [getMatch](#getmatch) - Get match;
* [setEscape](#setescape) - Set escape;
* [getEscape](#getescape) - Get escape;
* [newLines](#newlines) - Enable/Disable new lines;
* [isUsingNewLines](#isusingnewlines) - Determine if allow new lines;
* [trim](#trim) - Enable/Disable trim of the string;
* [isTrimmed](#istrimmed) - Determine if allow trim;
* [replaceCallback](#replacecallback) - Replace namespace;
* [toString](#tostring) - Get regex code.

**Magic methods:**

* [__toString](#__tostring) - See [toString](#toString) method;

## method

Description.

```php
method(mixed ...$args): mixed
```

`...$args` - Arguments.

_Example:_

```php
\Greg\Support\Html::method(...$args);
```
