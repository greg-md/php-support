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
* [append](#append) - Append a value to an array;
* [appendRef](#appendRef) - Append a value reference to an array;
* [appendKey](#appendKey) - Append a key-value to an array;
* [appendKeyRef](#appendKeyRef) - Append a key-value reference to an array;
* [appendIndex](#appendIndex) - Append an index-value to an array;
* [appendIndexRef](#appendIndexRef) - Append an index-value reference to an array;
* [prepend](#prepend) - Prepend a value to an array;
* [prependRef](#prependRef) - Prepend a value reference to an array;
* [prependKey](#prependKey) - Prepend a key-value to an array;
* [prependKeyRef](#prependKeyRef) - Prepend a key-value reference to an array;
* [prependIndex](#prependIndex) - Prepend an index-value to an array;
* [prependIndexRef](#prependIndexRef) - Prepend an index-value reference to an array;
* [first](#first) - Get the first value of an array;
* [firstRef](#firstRef) - Get the first value reference of an array;
* [last](#last) - Get the last value of an array;
* [lastRef](#lastRef) - Get the last value reference of an array;
* [firstKey](#firstKey) - Get the first key of an array;
* [lastKey](#lastKey) - Get the last key of an array;
* [map](#map) - Map an array;
* [mapRecursive](#mapRecursive) - Map an array recursively;
* [filter](#filter) - Filter an array;
* [filterRecursive](#filterRecursive) - Filter an array recursively;
* [group](#group) - Group an array;
* [inArrayValues](#inArrayValues) - Determine if values exists in an array;
* [pairs](#pairs) - Combine an array with key-value;
* [isFulfilled](#isFulfilled) - Determine if an array is fulfilled;
* [each](#each) - Parse an array an exchange their key-value;
* [count](#count) - Count an array;
* [pack](#pack) - Pack an array;
* [fixIndexes](#fixIndexes) - Fix indexes of an array;
* [packIndexes](#packIndexes) - Pack indexes of an array;
* [packIndexesRef](#packIndexesRef) - Pack indexes of an array, using values reference;
* [unpackIndexes](#unpackIndexes) - Unpack indexes of an array;
* [unpackIndexesRef](#unpackIndexesRef) - Unpack indexes of an array, using values reference;
* [valuesRecursive](#valuesRecursive) - Get values of an array recursively;

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
