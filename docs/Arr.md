# Array Documentation

`\Greg\Support\Arr` is working with arrays.

# Constants:

```php
const INDEX_DELIMITER = '.';
```

# Methods:

* [has](#has) - Determine if a key or an array of keys exists in an array;
* [hasIndex](#hasindex) - Determine if an index or an array of indexes exists in an array;
* [set](#set) - Set a value to an array;
* [setRef](#setref) - Set a value reference to an array;
* [setIndex](#setindex) - Set a value to an array, using index;
* [setIndexRef](#setindexref) - Set a value reference to an array, using index;
* [get](#get) - Get a value or an array of values from an array;
* [getRef](#getref) - Get a value reference or an array of values reference from an array;
* [getForce](#getforce) - Get a value from an array. If the key does not exists, it is added to the array;
* [getForceRef](#getforceref) - Get a value reference from an array. If the key does not exists, it is added to the array;
* [getArray](#getarray) - Get a value as array from an array;
* [getArrayRef](#getarrayref) - Get a value reference as array from an array;
* [getArrayForce](#getarrayforce) - Get a value as array from an array. If the key does not exists, it is added to the array;
* [getArrayForceRef](#getarrayforceref) - Get a value reference as array from an array. If the key does not exists, it is added to the array;
* [getIndex](#getindex) - Get a value from an array, using index;
* [getIndexRef](#getindexref) - Get a value reference from an array, using index;
* [getIndexForce](#getindexforce) - Get a value from an array, using index. If the index does not exists, it is added to the array;
* [getIndexForceRef](#getindexforceref) - Get a value reference from an array, using index. If the index does not exists, it is added to the array;
* [getIndexArray](#getindexarray) - Get a value as array from an array, using index;
* [getIndexArrayRef](#getindexarrayref) - Get a value reference as array from an array, using index;
* [getIndexArrayForce](#getindexarrayforce) - Get a value as array from an array, using index. If the index does not exists, it is added to the array;
* [getIndexArrayForceRef](#getindexarrayforceref) - Get a value reference as array from an array, using index. If the index does not exists, it is added to the array;
* [del](#del) - Delete a value from an array;
* [delIndex](#delindex) - Delete a value from an array, using index;
* [append](#append) - Append a value to an array;
* [appendRef](#appendref) - Append a value reference to an array;
* [appendKey](#appendkey) - Append a key-value to an array;
* [appendKeyRef](#appendkeyref) - Append a key-value reference to an array;
* [appendIndex](#appendindex) - Append an index-value to an array;
* [appendIndexRef](#appendindexref) - Append an index-value reference to an array;
* [prepend](#prepend) - Prepend a value to an array;
* [prependRef](#prependref) - Prepend a value reference to an array;
* [prependKey](#prependkey) - Prepend a key-value to an array;
* [prependKeyRef](#prependkeyref) - Prepend a key-value reference to an array;
* [prependIndex](#prependindex) - Prepend an index-value to an array;
* [prependIndexRef](#prependindexref) - Prepend an index-value reference to an array;
* [fixIndexes](#fixindexes) - Fix indexes of an array;
* [fixIndexesRef](#fixindexesref) - Fix indexes of an array, using values reference;
* [packIndexes](#packindexes) - Pack indexes of an array;
* [packIndexesRef](#packindexesref) - Pack indexes of an array, using values reference;
* [unpackIndexes](#unpackindexes) - Unpack indexes of an array;
* [unpackIndexesRef](#unpackindexesref) - Unpack indexes of an array, using values reference;
* [first](#first) - Get the first value of an array;
* [firstRef](#firstref) - Get the first value reference of an array;
* [last](#last) - Get the last value of an array;
* [lastRef](#lastref) - Get the last value reference of an array;
* [firstKey](#firstkey) - Get the first key of an array;
* [lastKey](#lastkey) - Get the last key of an array;
* [suffix](#suffix) - Add a suffix to array values;
* [prefix](#prefix) - Add a prefix to array values;
* [map](#map) - Map an array;
* [mapRecursive](#maprecursive) - Map an array recursively;
* [filter](#filter) - Filter an array;
* [filterRecursive](#filterrecursive) - Filter an array recursively;
* [group](#group) - Group an array;
* [inArrayValues](#inarrayvalues) - Determine if values exists in an array;
* [pairs](#pairs) - Combine an array with key-value;
* [isFulfilled](#isfulfilled) - Determine if an array is fulfilled;
* [each](#each) - Parse an array an exchange their key-value;
* [count](#count) - Count an array;
* [pack](#pack) - Pack an array;
* [values](#values) - Get values of an array;
* [valuesRecursive](#valuesrecursive) - Get values of an array recursively;

## has

Determine if a key or an array of keys exists in an array.

```php
has(array &$array, string|array $key): boolean
```

`$array` - The array;  
`$key` - Could be a key or an array of keys.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => 'BAR'];

\Greg\Support\Arr::has($array, 'foo'); // result: true
```

## hasIndex

Determine if an index or an array of indexes exists in an array.

```php
hasIndex(array &$array, string|array $index, string $delimiter = self::INDEX_DELIMITER): boolean
```

`$array` - The array;  
`$index` - Could be an index or an array of indexes;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'bar' => 'BAR'];

\Greg\Support\Arr::hasIndex($array, 'foo.bar'); // result: true
```

## set

Set a value to an array.

```php
set(array &$array, string $key, mixed $value): array
```

`$array` - The array;  
`$key` - Key;  
`$value` - Value.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::set($array, 'bar', 'BAR'); // result: ['foo' => 'FOO', 'bar' => 'BAR']
```

## setRef

Set a value reference to an array.

```php
setRef(array &$array, string $key, mixed &$value): array
```

`$array` - The array;  
`$key` - Key;  
`$value` - Value reference.

_Example:_

```php
$array = ['foo' => 'FOO'];

$bar = 'BAR';

\Greg\Support\Arr::setRef($array, 'bar', $bar); // result: ['foo' => 'FOO', 'bar' => 'BAR']

$bar = 'BAR2';

// $array: ['foo' => 'FOO', 'bar' => 'BAR2'];
```

## setIndex

Set a value to an array, using index.

```php
setIndex(array &$array, string $index, mixed $value, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$value` - Value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::setIndex($array, 'bar.baz', 'BAZ'); // result: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ']]
```

## setIndexRef

Set a value reference to an array, using index.

```php
setIndexRef(array &$array, string $index, mixed &$value, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$value` - Value reference;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

$baz = 'BAZ';

\Greg\Support\Arr::setIndexRef($array, 'bar.baz', $baz); // result: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ']]

$baz = 'BAZ2';

// $array: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ2']];
```

## get

Get a value or an array of values from an array.

```php
get(array &$array, string $key, string $else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::get($array, 'foo'); // result: FOO
```

## getRef

Get a value or an array of values from an array.

```php
getRef(array &$array, string $key, string &$else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

$foo = \Greg\Support\Arr::getRef($array, 'foo'); // result: FOO

$foo = 'FOO2';

// $array: ['foo' => 'FOO2']
```
