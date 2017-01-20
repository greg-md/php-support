# URL Documentation

`\Greg\Support\Url` is working with URLs.

# Constants

```php
const UA = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
```

# Methods:

* [hasSchema](#hasSchema) - Determine if an URL has schema;
* [noSchema](#noSchema) - Get an URL without schema;
* [schema](#schema) - Set current schema to an URL;
* [withSchema](#withSchema) - Add current schema to an URL if was not defined;
* [shortSchema](#shortSchema) - Set short schema to an URL;
* [secured](#secured) - Set secured schema to an URL;
* [unsecured](#unsecured) - Set unsecured schema to an URL;
* [absolute](#absolute) - Transform a relative URL to server absolute URL;
* [relative](#relative) - Transform an URL to relative URL;
* [serverRelative](#serverRelative) - Transform a server absolute URL to relative URL;
* [host](#host) - Get host from an URL;
* [hostLevel](#hostLevel) - Get host level from an URL;
* [hostEquals](#hostEquals) - Determine if two URLs are equal by their host;
* [root](#root) - Get root of an URL;
* [removeQueryString](#removeQueryString) - Remove query string of an URL;
* [base](#base) - Get server base URL;
* [addQuery](#addQuery) - Add a query to an URL;
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
\Greg\Support\Url::hasSchema('google.com'); // result: false
\Greg\Support\Url::hasSchema('http://google.com'); // result: true
```
