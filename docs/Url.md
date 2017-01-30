# URL Documentation

`\Greg\Support\Url` is working with URLs.

# Table of contents:

* [Constants](#constants)
* [Methods](#methods)

# Constants

```php
const UA = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
```

# Methods:

* [hasSchema](#hasschema) - Determine if an URL has schema;
* [noSchema](#noschema) - Get an URL without schema;
* [schema](#schema) - Set current schema to an URL;
* [shorted](#shorted) - Set short schema to an URL;
* [secured](#secured) - Set secured schema to an URL;
* [unsecured](#unsecured) - Set unsecured schema to an URL;
* [schemly](#schemly) - Add current schema to an URL if was not defined;
* [shortly](#shortly) - Set short schema to an URL if was not defined;
* [securely](#securely) - Set secured schema to an URL if was not defined;
* [unsecurely](#unsecurely) - Set unsecured schema to an URL if was not defined;
* [absolute](#absolute) - Transform a relative URL to server absolute URL;
* [relative](#relative) - Transform an URL to relative URL;
* [serverRelative](#serverrelative) - Transform a server absolute URL to relative URL;
* [host](#host) - Get host from an URL;
* [hostLevel](#hostlevel) - Get host level from an URL;
* [hostEquals](#hostequals) - Determine if two URLs are equal by their host;
* [root](#root) - Get root of an URL;
* [path](#path) - Remove query string of an URL;
* [base](#base) - Get server base URL;
* [addQuery](#addquery) - Add a query to an URL;
* [init](#init) - Init an cURL handle for an URL;
* [effective](#effective) - Get effective URL of an URL;
* [contents](#contents) - Get contents of an URL.

## hasSchema

Determine if an URL has schema.

```php
hasSchema(string $absolute): boolean
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::hasSchema('example.com'); // result: false

\Greg\Support\Url::hasSchema('http://example.com'); // result: true
```

## noSchema

Get an URL without schema.

```php
noSchema(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::noSchema('http://example.com'); // result: example.com
```

## schema

Set current schema to an URL.

```php
schema(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::schema('example.com'); // result: http://example.com
```

## shorted

Set short schema to an URL.

```php
shorted(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::shorted('http://example.com/styles.css'); // result: //example.com/styles.css
```

## secured

Set secured schema to an URL.

```php
secured(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::secured('http://example.com'); // result: https://example.com
```

## unsecured

Set unsecured schema to an URL.

```php
unsecured(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::unsecured('https://example.com'); // result: http://example.com
```

## schemly

Add current schema to an URL if was not defined.

```php
schemly(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::schemly('example.com'); // result: http://example.com

\Greg\Support\Url::schemly('https://example.com'); // result: https://example.com
```

## shortly

Set short schema to an URL if was not defined.

```php
shorted(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::shortly('http://example.com/styles.css'); // result: //example.com/styles.css
```

## securely

Set secured schema to an URL if was not defined.

```php
securely(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::securely('http://example.com'); // result: https://example.com
```

## unsecurely

Set unsecured schema to an URL if was not defined.

```php
unsecurely(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::unsecurely('https://example.com'); // result: http://example.com
```

## absolute

Transform a relative URL to server absolute URL.

```php
absolute(string $relative): string
```

`$relative` - The URL.

_Example:_

```php
// Let say server url is localhost

\Greg\Support\Url::absolute('/foo'); // result: http://localhost/foo
```

## relative

Transform an absolute URL to relative URL.

```php
relative(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::relative('http://example.com/foo'); // result: /foo
```

## serverRelative

Transform a server absolute URL to relative URL.

```php
serverRelative(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
// Let say server url is localhost

\Greg\Support\Url::serverRelative('http://example.com/foo'); // result: http://example.com/foo

\Greg\Support\Url::serverRelative('http://localhost/foo'); // result: /foo
```

## host

Get host from an URL.

```php
host(string $absolute, boolean $stripWWW = true): string
```

`$absolute` - The URL;  
`$stripWWW` - Strip www from URL.

_Example:_

```php
\Greg\Support\Url::host('http://example.com/foo'); // result: example.com
```

## hostLevel

Get host level from an URL.

```php
hostLevel(string $absolute, int $level = 2, boolean $stripWWW = true): string
```

`$absolute` - The URL;  
`$level` - Host level;  
`$stripWWW` - Strip www from URL.

_Example:_

```php
\Greg\Support\Url::hostLevel('http://mobile.example.com/foo'); // result: example.com

\Greg\Support\Url::hostLevel('http://mobile.example.com/foo', 3); // result: mobile.example.com
```

## hostEquals

Determine if two URLs are equal by their host.

```php
hostEquals(string $absolute1, string $absolute2, int $level = 2): boolean
```

`$absolute1` - The first URL;  
`$absolute2` - The second URL;  
`$level` - Host level.

_Example:_

```php
\Greg\Support\Url::hostEquals('http://v1.example.com/foo', 'http://v2.example.com/foo'); // result: true
```

## root

Get root of an URL.

```php
root(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::root('http://example.com/foo'); // result: http://example.com
```

## path

Get without query string.

```php
path(string $url): string
```

`$url` - The URL.

_Example:_

```php
\Greg\Support\Url::path('/foo?bar=BAR'); // result: /foo
```

## base

Get server base URL.

```php
base(string $path = '/', boolean $absolute = false): string
```

`$path` - Path;  
`$absolute` - Return absolute URL.

_Example:_

```php
// Let say your base uri is /module

\Greg\Support\Url::base('/foo'); // result: /module/foo
```

## addQuery

Add a query to an URL.

```php
addQuery(string $url, string|array $query): string
```

`$url` - URL;  
`$query` - Query.

_Example:_

```php
\Greg\Support\Url::addQuery('/?foo=FOO', ['bar' => 'BAR']); // result: /?foo=FOO&bar=BAR
```

## init

Init an cURL handle for an URL.

```php
init(string $absolute, boolean $verbose = false): resource
```

`$absolute` - The URL;  
`$verbose` - Verbose.

_Example:_

```php
$handle = \Greg\Support\Url::init('http://example.com');

$contents = curl_exec($handle);
```

## effective

Get effective URL of an URL.

```php
effective(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::effective('http://some.old.example.com'); // result: http://example.com
```

## contents

Get contents of an URL.

```php
contents(string $absolute): string
```

`$absolute` - The URL.

_Example:_

```php
\Greg\Support\Url::contents('http://example.com'); // result: contents of the url
```
