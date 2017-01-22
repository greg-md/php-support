# Array Documentation

`\Greg\Support\Arr` is working with arrays.

# Table of contents:

* [Constants](#constants)
* [Methods](#methods)

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
* [getForce](#getforce) - Get a value or an array of values from an array. If the key does not exists, it is added to the array;
* [getForceRef](#getforceref) - Get a value reference or an array of values reference from an array. If the key does not exists, it is added to the array;
* [getArray](#getarray) - Get a value as array or an array of values as array from an array;
* [getArrayRef](#getarrayref) - Get a value reference as array or an array of values reference as array from an array;
* [getArrayForce](#getarrayforce) - Get a value as array or an array of values as array from an array. If the key does not exists, it is added to the array;
* [getArrayForceRef](#getarrayforceref) - Get a value reference as array from an array. If the key does not exists, it is added to the array;
* [getIndex](#getindex) - Get a value or an array of values from an array, using index;
* [getIndexRef](#getindexref) - Get a value reference or an array of values reference from an array, using index;
* [getIndexForce](#getindexforce) - Get a value or an array of values from an array, using index. If the index does not exists, it is added to the array;
* [getIndexForceRef](#getindexforceref) - Get a value reference or an array of values reference from an array, using index. If the index does not exists, it is added to the array;
* [getIndexArray](#getindexarray) - Get a value as array or an array of values as array from an array, using index;
* [getIndexArrayRef](#getindexarrayref) - Get a value reference as array or an array of values reference as array from an array, using index;
* [getIndexArrayForce](#getindexarrayforce) - Get a value as array or an array of values as array from an array, using index. If the index does not exists, it is added to the array;
* [getIndexArrayForceRef](#getindexarrayforceref) - Get a value reference as array or an array of values reference as array from an array, using index. If the index does not exists, it is added to the array;
* [remove](#remove) - Remove a value or an array of values from an array;
* [removeIndex](#removeIndex) - Remove a value or an array of values from an array, using index;
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
* [prefix](#prefix) - Add a prefix to array values;
* [suffix](#suffix) - Add a suffix to array values;
* [map](#map) - Map an array;
* [mapRecursive](#maprecursive) - Map an array recursively;
* [filter](#filter) - Filter an array;
* [filterRecursive](#filterrecursive) - Filter an array recursively;
* [values](#values) - Get values of an array;
* [valuesRecursive](#valuesrecursive) - Get values of an array recursively.
* [group](#group) - Group an array;
* [in](#inarrayvalues) - Determine if value or an array of values exists in an array;
* [pairs](#pairs) - Combine an array with key-value;
* [isFulfilled](#isfulfilled) - Determine if an array is fulfilled;
* [each](#each) - Parse an array into new one;
* [pack](#pack) - Pack an array;

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
get(array &$array, string|array $key, mixed|array<mixed> $else = null): mixed
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

Get a value reference or an array of values reference from an array.

```php
getRef(array &$array, string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

$foo = &\Greg\Support\Arr::getRef($array, 'foo'); // result: FOO

$foo = 'FOO2';

// $array: ['foo' => 'FOO2']
```

## getForce

Get a value or an array of values from an array.
If the key does not exists, it is added to the array.

```php
getForce(array &$array, string|array $key, mixed|array<mixed> $else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getForce($array, 'bar'); // result: null

// $array: ['foo' => 'FOO', 'bar' => null]
```

## getForceRef

Get a value reference or an array of values reference from an array.
If the key does not exists, it is added to the array.

```php
getForceRef(array &$array, string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

$bar = &\Greg\Support\Arr::getForceRef($array, 'bar'); // result: null

$bar = 'BAR';

// $array: ['foo' => 'FOO', 'bar' => 'BAR']
```

## getArray

Get a value as array or an array of values as array from an array.

```php
getArray(array &$array, string|array $key, mixed|array<mixed> $else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getArray($array, 'foo'); // result: ['FOO']
```

## getArrayRef

Get a value reference as array or an array of values reference as array from an array.

```php
getArrayRef(array &$array, string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

$foo = &\Greg\Support\Arr::getArrayRef($array, 'foo'); // result: ['FOO']

// $array: ['foo' => ['FOO']]

$foo[0] = 'FOO2';

// $array: ['foo' => ['FOO2']]
```

## getArrayForce

Get a value as array or an array of values as array from an array.
If the key does not exists, it is added to the array.

```php
getArrayForce(array &$array, string|array $key, mixed|array<mixed> $else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getArrayForce($array, 'bar'); // result: []

// $array: ['foo' => 'FOO', 'bar' => []]
```

## getArrayForceRef

Get a value reference as array or an array of values reference as array from an array.
If the key does not exists, it is added to the array.

```php
getArrayForceRef(array &$array, string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

$bar = &\Greg\Support\Arr::getArrayForceRef($array, 'bar'); // result: []

$bar[0] = 'BAR';

// $array: ['foo' => 'FOO', 'bar' => ['BAR']]
```

## getIndex

Get a value or an array of values from an array, using index.

```php
getIndex(array &$array, string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR']];

\Greg\Support\Arr::getIndex($array, 'foo.bar'); // result: BAR
```

## getIndexRef

Get a value reference or an array of values reference from an array, using index.

```php
getIndexRef(array &$array, string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR']];

$bar = &\Greg\Support\Arr::getIndexRef($array, 'foo.bar'); // result: BAR

$bar = 'BAR2';

// $array: ['foo' => ['bar' => 'BAR2']]
```

## getIndexForce

Get a value or an array of values from an array, using index. If the index does not exists, it is added to the array.

```php
getIndexForce(array &$array, string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getIndexForce($array, 'bar.baz'); // result: null

// $array: ['foo' => 'FOO', 'bar' => ['baz' => null]]
```

## getIndexForceRef

Get a value reference or an array of values reference from an array, using index. If the index does not exists, it is added to the array.

```php
getIndexForceRef(array &$array, string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

$baz = &\Greg\Support\Arr::getIndexForceRef($array, 'bar.baz'); // result: null

$baz = 'BAZ';

// $array: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ']]
```

## getIndexArray

Get a value as array or an array of values as array from an array, using index.

```php
getIndexArray(array &$array, string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR']];

\Greg\Support\Arr::getIndexArray($array, 'foo.bar'); // result: ['BAR']
```

## getIndexArrayRef

Get a value reference as array or an array of values reference as array from an array, using index.

```php
getIndexArrayRef(array &$array, string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR']];

$foo = &\Greg\Support\Arr::getIndexArrayRef($array, 'foo.bar'); // result: ['BAR']

// $array: ['foo' => ['bar' => ['BAR']]]

$foo[0] = 'BAR2';

// $array: ['foo' => ['bar' => ['BAR2']]]
```

## getIndexArrayForce

Get a value as array or an array of values as array from an array, using index. If the index does not exists, it is added to the array.

```php
getIndexArrayForce(array &$array, string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getIndexArrayForce($array, 'bar.baz'); // result: []

// $array: ['foo' => 'FOO', 'bar' => ['baz' => []]]
```

## getIndexArrayForceRef

Get a value reference as array or an array of values reference as array from an array, using index. If the index does not exists, it is added to the array.

```php
getIndexArrayForceRef(array &$array, string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

$baz = &\Greg\Support\Arr::getIndexArrayForceRef($array, 'bar.baz'); // result: []

$baz[0] = 'BAZ';

// $array: ['foo' => 'FOO', 'bar' => ['baz' => ['BAZ']]]
```

## remove

Remove a value or an array of values from an array.

```php
remove(array &$array, string|array $key): array
```

`$array` - The array;  
`$key` - Key.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::remove($array, 'foo'); // result: []
```

## removeIndex

Remove a value or an array of values from an array, using index.

```php
removeIndex(array &$array, string|array $index, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR']];

\Greg\Support\Arr::remove($array, 'foo.bar'); // result: ['foo' => []]
```

## append

Append a value to an array.

```php
append(array &$array, mixed $value, mixed ...$values): array
```

`$array` - The array;  
`$value` - Value;  
`...$values` - Other values.

_Example:_

```php
$array = ['foo'];

\Greg\Support\Arr::append($array, 'bar'); // result: ['foo', 'bar']
```

## appendRef

Append a value reference to an array.

```php
appendRef(array &$array, mixed &$value, mixed &...$values): array
```

`$array` - The array;  
`$value` - Value reference;  
`...$values` - Other values reference.

_Example:_

```php
$array = ['foo'];

$bar = 'bar';

\Greg\Support\Arr::appendRef($array, $bar); // result: ['foo', 'bar']

$bar = 'bar2';

// $array: ['foo', 'bar2']
```

## appendKey

Append a key-value to an array.

```php
appendKey(array &$array, string $key, mixed $value = null): array
```

`$array` - The array;  
`$key` - Key;  
`$value` - Value.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => 'BAR'];

\Greg\Support\Arr::appendKey($array, 'foo', 'FOO2'); // result: ['bar' => 'BAR', 'foo' => 'FOO2']
```

## appendKeyRef

Append a key-value reference to an array.

```php
appendKeyRef(array &$array, string $key, mixed &$value = null): array
```

`$array` - The array;  
`$key` - Key;  
`$value` - Value.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => 'BAR'];

$foo = 'FOO2';

\Greg\Support\Arr::appendKeyRef($array, 'foo', $foo); // result: ['bar' => 'BAR', 'foo' => 'FOO2']

$foo = 'FOO3';

// $array: ['bar' => 'BAR', 'foo' => 'FOO3']
```

## appendIndex

Append an index-value to an array.

```php
appendIndex(array &$array, string $index, mixed $value = null, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$value` - Value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR', 'baz' => 'BAZ']];

\Greg\Support\Arr::appendIndex($array, 'foo.bar', 'BAR2'); // result: ['foo' => ['baz' => 'BAZ', 'bar' => 'BAR2']]
```

## appendIndexRef

Append an index-value reference to an array.

```php
appendIndexRef(array &$array, string $index, mixed &$value = null, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$value` - Value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR', 'baz' => 'BAZ']];

$bar = 'BAR2';

\Greg\Support\Arr::appendIndexRef($array, 'foo.bar', $bar); // result: ['foo' => ['baz' => 'BAZ', 'bar' => 'BAR2']]

$bar = 'BAR3';

// $array: ['foo' => ['baz' => 'BAZ', 'bar' => 'BAR3']]
```

## prepend

Prepend a value to an array.

```php
prepend(array &$array, mixed $value, mixed ...$values): array
```

`$array` - The array;  
`$value` - Value;  
`...$values` - Other values.

_Example:_

```php
$array = ['foo'];

\Greg\Support\Arr::prepend($array, 'bar'); // result: ['bar', 'foo']
```

## prependRef

Prepend a value reference to an array.

```php
prependRef(array &$array, mixed &$value, mixed &...$values): array
```

`$array` - The array;  
`$value` - Value reference;  
`...$values` - Other values reference.

_Example:_

```php
$array = ['foo'];

$bar = 'bar';

\Greg\Support\Arr::prependRef($array, $bar); // result: ['bar', 'foo']

$bar = 'bar2';

// $array: ['bar2', 'foo']
```

## prependKey

Prepend a key-value to an array.

```php
prependKey(array &$array, string $key, mixed $value = null): array
```

`$array` - The array;  
`$key` - Key;  
`$value` - Value.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => 'BAR'];

\Greg\Support\Arr::prependKey($array, 'bar', 'BAR2'); // result: ['bar' => 'BAR2', 'foo' => 'FOO']
```

## prependKeyRef

Prepend a key-value reference to an array.

```php
prependKeyRef(array &$array, string $key, mixed &$value = null): array
```

`$array` - The array;  
`$key` - Key;  
`$value` - Value.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => 'BAR'];

$bar = 'BAR2';

\Greg\Support\Arr::prependKeyRef($array, 'bar', $bar); // result: ['bar' => 'BAR2', 'foo' => 'FOO']

$bar = 'BAR3';

// $array: ['bar' => 'BAR3', 'foo' => 'FOO']
```

## prependIndex

Prepend an index-value to an array.

```php
prependIndex(array &$array, string $index, mixed $value = null, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$value` - Value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR', 'baz' => 'BAZ']];

\Greg\Support\Arr::prependIndex($array, 'foo.baz', 'BAZ2'); // result: ['foo' => ['baz' => 'BAZ2', 'bar' => 'BAR']]
```

## prependIndexRef

Prepend an index-value reference to an array.

```php
prependIndexRef(array &$array, string $index, mixed &$value = null, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$value` - Value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR', 'baz' => 'BAZ']];

$baz = 'BAZ2';

\Greg\Support\Arr::prependRef($array, 'foo.baz', $baz); // result: ['foo' => ['baz' => 'BAZ2', 'bar' => 'BAR']]

$baz = 'BAZ3';

// $array: ['foo' => ['baz' => 'BAZ3', 'bar' => 'BAR']]
```

## fixIndexes

Fix indexes of an array.

```php
fixIndexes(array &$array, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo.bar' => ['baz' => 'BAZ']];

\Greg\Support\Arr::fixIndexes($array); // result: ['foo' => ['bar' => ['baz' => 'BAZ']]]
```

## fixIndexesRef

Fix indexes of an array, using values reference.

```php
fixIndexesRef(array &$array, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$delimiter` - Index delimiter.

_Example:_

```php
$baz = 'BAZ';

$array = ['foo.bar' => ['baz' => &$baz]];

$fixed = \Greg\Support\Arr::fixIndexes($array); // result: ['foo' => ['bar' => ['baz' => 'BAZ']]]

$baz = 'BAZ2';

// $fixed: ['foo' => ['bar' => ['baz' => 'BAZ2']]]
```

## packIndexes

Pack indexes of an array.

```php
packIndexes(array &$array, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => ['baz' => 'BAZ']]];

\Greg\Support\Arr::packIndexes($array); // result: ['foo.bar.baz' => 'BAZ']
```

## packIndexesRef

Pack indexes of an array, using values reference.

```php
packIndexes(array &$array, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$delimiter` - Index delimiter.

_Example:_

```php
$baz = 'BAZ';

$array = ['foo' => ['bar' => ['baz' => &$baz]]];

$packed = \Greg\Support\Arr::packIndexes($array); // result: ['foo.bar.baz' => 'BAZ']

$baz = 'BAZ2';

// $packed: ['foo.bar.baz' => 'BAZ2']
```

## unpackIndexes

Unpack indexes of an array.

```php
unpackIndexes(array &$array, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo.bar.baz' => 'BAZ'];

\Greg\Support\Arr::packIndexes($array); // result: ['foo' => ['bar' => ['baz' => 'BAZ']]]
```

## unpackIndexesRef

Unpack indexes of an array, using values reference.

```php
unpackIndexes(array &$array, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$delimiter` - Index delimiter.

_Example:_

```php
$baz = 'BAZ';

$array = ['foo.bar.baz' => &$baz];

$unpacked = \Greg\Support\Arr::packIndexes($array); // result: ['foo' => ['bar' => ['baz' => 'BAZ']]]

$baz = 'BAZ2';

// $unpacked: ['foo' => ['bar' => ['baz' => 'BAZ2']]]
```

## first

Get the first value of an array.

```php
first(array &$array, callable(mixed $value, string $key): boolean $callable = null, mixed $else = null): mixed
```

`$array` - The array;  
`$callable` - Callable to filter values;  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value;  
&nbsp;&nbsp;&nbsp;&nbsp;`$key` - Key.  
`$else` - If the value was not found, return this value.

_Example:_

```php
$array = [1, 2, 3];

\Greg\Support\Arr::first($array); // result: 1

\Greg\Support\Arr::first($array, function ($value) { return $value === 2; }); // result: 2
```

## firstRef

Get the first value reference of an array. See [first](#first) method.

## last

Get the last value of an array. See [first](#first) method.

## lastRef

Get the last value reference of an array. See [last](#last) method.

## firstKey

Get the first key of an array.

```php
firstKey(array &$array, callable(string $key, mixed $value): boolean $callable = null, mixed $else = null): mixed
```

`$array` - The array;  
`$callable` - Callable to filter keys;  
&nbsp;&nbsp;&nbsp;&nbsp;`$key` - Key;  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value.  
`$else` - If the value was not found, return this value.

_Example:_

```php
$array = [1 => 'one', 2 => 'two', 3 => 'three'];

\Greg\Support\Arr::firstKey($array); // result: 1

\Greg\Support\Arr::firstKey($array, function ($key) { return $key === 2; }); // result: 2
```

## lastKey

Get the last key of an array. See [firstKey](#firstKey) method.

## prefix

Add a prefix to array values.

```php
prefix(array &$array, string $prefix): array
```

`$array` - The array;  
`$prefix` - Prefix.

_Example:_

```php
$array = ['foo', 'bar'];

\Greg\Support\Arr::prefix($array, 'pre_'); // result: ['pre_foo', 'pre_bar'] 
```

## suffix

Add a suffix to array values. See [prefix](#prefix) method.

## map

Map an array.

```php
map(array &$array, callable(mixed $value, mixed ...$values): string $callable, array &...$arrays): array
```

`$array` - The array;  
`$callable` - Callable;  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value;  
&nbsp;&nbsp;&nbsp;&nbsp;`...$values` - Other values from `...$arrays`.  
`...$arrays` - Variable list of array arguments to run through the callback function.

_Example:_

```php
$array = [1, 2, 3];

\Greg\Support\Arr::map($array, function ($n) { return pow($n, 2); }); // result: [1, 4, 9]
```

## mapRecursive

Map an array recursively. See [map](#map) method.

## filter

Filter an array.

```php
filter(array &$array, callable(mixed $value, string $key): boolean $callable = null): array
```

`$array` - The array;  
`$callable` - Callable.  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value;  
&nbsp;&nbsp;&nbsp;&nbsp;`$key` - Key.

_Example:_

```php
$array = [1, 2, null, 0, 3, ''];

\Greg\Support\Arr::filter($array); // result: [0 => 1, 1 => 2, 4 => 3]
```

## filterRecursive

Filter an array recursively.

```php
filter(array &$array, callable(mixed $value, string $key): boolean $callable = null, int $until = 0): array
```

`$array` - The array;  
`$callable` - Callable;  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value;  
&nbsp;&nbsp;&nbsp;&nbsp;`$key` - Key.
`$until` - Max level to go recursive until the value.

_Example:_

```php
$array = [1, 2, [null], 0, 3, ''];

\Greg\Support\Arr::filter($array); // result: [0 => 1, 1 => 2, 4 => 3]
```

## values

Get values of an array.

```php
values(array $array): array
```

`$array` - The array.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => 'BAR'];

\Greg\Support\Arr::values($array); // result: ['FOO', 'BAR']
```

## valuesRecursive

Get values of an array recursively.

```php
valuesRecursive(&$array, int $until = 0): array
```

`$array` - The array;  
`$until` - Max level to go recursive until the value.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ']];

\Greg\Support\Arr::values($array); // result: ['FOO', ['BAZ']]
```

## group

Group an array.

```php
group(array $arrays, int|string|array|callable(array $value) $maxLevel = 1, boolean $multipleValues = false, boolean $removeGroupedKey = false): array
```

`$array` - An array of arrays;  
`$maxLevel` - Group maximum level;  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value.  
`$multipleValues` - Allow to set all values in an array;  
`$removeGroupedKey` - Remove grouped key from the array.

_Example:_

```php
$array = [
    [
        'a' => '1',
        'b' => '2',
        'c' => '22',
    ],
    [
        'a' => '3',
        'b' => '4',
        'c' => '44',
    ],
];

$grouped = \Greg\Support\Arr::group($array, 'a');

// $grouped: [
//     1 => [
//         'a' => '1',
//         'b' => '2',
//         'c' => '22',
//     ],
//     3 => [
//         'a' => '3',
//         'b' => '4',
//         'c' => '44',
//     ],
// ]
```

## in

Determine if value or an array of values exists in an array.

```php
in(array &$array, string|array $value, boolean $strict = false): boolean
```

`$array` - The array;  
`$value` - Value;  
`$string` - Enable strict mode.

_Example:_

```php
$array = ['foo', 'bar'];

\Greg\Support\Arr::in($array, 'foo'); // result: true
\Greg\Support\Arr::in($array, ['foo', 'baz']); // result: false
```

## pairs

Combine an array with key-value.

```php
pairs(array &$array, string $key, string $value): array
```

`$array` - The array;  
`$key` - Key;  
`$value` - Value.

_Example:_

```php
$array = [['foo' => 'FOO', 'bar' => 'BAR'], ['foo' => 'FOO2', 'bar' => 'BAR2']];

\Greg\Support\Arr::pairs($array, 'foo', 'bar'); // result: ['FOO' => 'BAR', 'FOO2' => 'BAR2']
```

## isFulfilled

Determine if an array is fulfilled.

```php
isFulfilled(array &$array, callable(mixed $value, string $key): boolean $callable = null): boolean
```

`$array` - The array;  
`$callable` - Callable.  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value;  
&nbsp;&nbsp;&nbsp;&nbsp;`$key` - Key.

_Example:_

```php
$array = ['foo', 'bar', null];

\Greg\Support\Arr::isFulfilled($array); // result: false
```

## each

Parse an array into new one.

```php
each(array &$array, callable(mixed $value, string $key): array[mixed $value, string $key] $callable): array
```

`$array` - The array;  
`$callable` - Callable.  
&nbsp;&nbsp;&nbsp;&nbsp;`$value` - Value;  
&nbsp;&nbsp;&nbsp;&nbsp;`$key` - Key.

_Example:_

```php
$array = ['foo', 'bar'];

\Greg\Support\Arr::each($array, function($value, $key) { return [$key, $value]; }); // result: ['foo' => 0, 'bar' => 1]
```

## pack

Pack an array.

```php
pack(array $array, string $glue = null): array
```

`$array` - The array;  
`$glue` - Glue.

_Example:_

```php
$array = ['foo' => 'FOO', 'bar' => 'BAR'];

\Greg\Support\Arr::pack($array, '-'); // result: ['foo' => 'foo-FOO', 'bar' => 'bar-BAR']
```
