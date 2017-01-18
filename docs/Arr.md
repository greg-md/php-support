# Array Documentation

`\Greg\Support\Arr` is working with arrays.

# Methods:

* [has](#has) - Determine if a key exists in an array;
* [hasIndex](#hasIndex) - Determine if an index exists in an array;
* [set](#set) - Set a value to an array;
* [setRef](#setRef) - Set a value reference to an array;
* [setIndex](#setIndex) - Set a value to an array, using index;
* [setIndexRef](#setIndexRef) - Set a value reference to an array, using index;
* [get](#get) - Get a value from an array;
* [getRef](#getRef) - Get a value reference from an array;
* [getForce](#getForce) - Get a value from an array. If the key does not exists, it is added to the array;
* [getForceRef](#getForceRef) - Get a value reference from an array. If the key does not exists, it is added to the array;
* [getArray](#getArray) - Get a value as array from an array;
* [getArrayRef](#getArrayRef) - Get a value reference as array from an array;
* [getArrayForce](#getArrayRef) - Get a value as array from an array. If the key does not exists, it is added to the array;
* [getArrayForceRef](#getArrayRef) - Get a value reference as array from an array. If the key does not exists, it is added to the array;
* [getIndex](#getIndex) - Get a value from an array, using index;
* [getIndexRef](#getIndexRef) - Get a value reference from an array, using index;
* [getIndexForce](#getIndexForce) - Get a value from an array, using index. If the index does not exists, it is added to the array;
* [getIndexForceRef](#getIndexForceRef) - Get a value reference from an array, using index. If the index does not exists, it is added to the array;
* [getIndexArray](#getIndexArray) - Get a value as array from an array, using index;
* [getIndexArrayRef](#getIndexArrayRef) - Get a value reference as array from an array, using index;
* [getIndexArrayForce](#getIndexArrayForce) - Get a value as array from an array, using index. If the index does not exists, it is added to the array;
* [getIndexArrayForceRef](#getIndexArrayForceRef) - Get a value reference as array from an array, using index. If the index does not exists, it is added to the array;
* [del](#del) - Delete a value from an array;
* [delIndex](#delIndex) - Delete a value from an array, using index;
* [suffix](#suffix) - Add a suffix to array values;
* [prefix](#prefix) - Add a prefix to array values;

## camelCase

Transform a string to `CamelCase`.

```php
camelCase(string $string): string
```

`$string` - The string.

_Example:_

```php
\Greg\Support\Str::camelCase('camel case'); // result: CamelCase
```
