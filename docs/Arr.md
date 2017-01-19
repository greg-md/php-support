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
* [del](#del) - Delete a value or an array of values from an array;
* [delIndex](#delindex) - Delete a value or an array of values from an array, using index;
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
get(array &$array, string|array $key, string|array $else = null): mixed
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
getRef(array &$array, string|array $key, string|array &$else = null): mixed
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
getForce(array &$array, string|array $key, string|array $else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getForce($array, 'bar'); // result: null

// $array = ['foo' => 'FOO', 'bar' => null]
```

## getForceRef

Get a value reference or an array of values reference from an array.
If the key does not exists, it is added to the array.

```php
getForceRef(array &$array, string|array $key, string|array &$else = null): mixed
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
getArray(array &$array, string|array $key, string $else|array = null): mixed
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
getArrayRef(array &$array, string|array $key, string|array &$else = null): mixed
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
getArrayForce(array &$array, string|array $key, string|array $else = null): mixed
```

`$array` - The array;  
`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getArrayForce($array, 'bar'); // result: []

// $array = ['foo' => 'FOO', 'bar' => []]
```

## getArrayForceRef

Get a value reference as array or an array of values reference as array from an array.
If the key does not exists, it is added to the array.

```php
getArrayForceRef(array &$array, string|array $key, string|array &$else = null): mixed
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
getIndex(array &$array, string|array $index, string|array $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
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
getIndexRef(array &$array, string|array $index, string|array &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
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
getIndexForce(array &$array, string|array $index, string|array $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getIndexForce($array, 'bar.baz'); // result: null

// $array = ['foo' => 'FOO', 'bar' => ['baz' => null]]
```

## getIndexForceRef

Get a value reference or an array of values reference from an array, using index. If the index does not exists, it is added to the array.

```php
getIndexForceRef(array &$array, string|array $index, string|array &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
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
getIndexArray(array &$array, string|array $index, string $else|array = null, string $delimiter = self::INDEX_DELIMITER): mixed
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
getIndexArrayRef(array &$array, string|array $index, string|array &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
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
getIndexArrayForce(array &$array, string|array $index, string|array $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$array` - The array;  
`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::getIndexArrayForce($array, 'bar.baz'); // result: []

// $array = ['foo' => 'FOO', 'bar' => ['baz' => []]]
```

## getIndexArrayForceRef

Get a value reference as array or an array of values reference as array from an array, using index. If the index does not exists, it is added to the array.

```php
getIndexArrayForceRef(array &$array, string|array $index, string|array &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
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

// $array = ['foo' => 'FOO', 'bar' => ['baz' => ['BAZ']]]
```

## del

Delete a value or an array of values from an array.

```php
del(array &$array, string|array $key): array
```

`$array` - The array;  
`$key` - Key.

_Example:_

```php
$array = ['foo' => 'FOO'];

\Greg\Support\Arr::del($array, 'foo'); // result: []
```

## delIndex

Delete a value or an array of values from an array, using index.

```php
delIndex(array &$array, string|array $index, string $delimiter = self::INDEX_DELIMITER): array
```

`$array` - The array;  
`$index` - Index;  
`$delimiter` - Index delimiter.

_Example:_

```php
$array = ['foo' => ['bar' => 'BAR']];

\Greg\Support\Arr::del($array, 'foo.bar'); // result: ['foo' => []]
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

\Greg\Support\Arr::appendRef($array, 'foo', $foo); // result: ['bar' => 'BAR', 'foo' => 'FOO2']

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

\Greg\Support\Arr::appendRef($array, 'foo.bar', $bar); // result: ['foo' => ['baz' => 'BAZ', 'bar' => 'BAR2']]

$bar = 'BAR3';

// $array: ['foo' => ['baz' => 'BAZ', 'bar' => 'BAR3']]
```
