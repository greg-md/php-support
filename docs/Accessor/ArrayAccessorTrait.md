# ArrayAccessorTrait Documentation

`\Greg\Support\Accessor\ArrayAccessorTrait` is a trait for **public** usage of an storage in a class.

_Example:_

```php
class Storage
{
    private $storage = [];
    
    use \Greg\Support\Accessor\ArrayAccessorTrait;

    private function &getAccessor()
    {
        return $this->storage;
    }
}
```

# Methods:

* [has](#has) - Determine if a key or an array of keys exists in accessor;
* [hasIndex](#hasindex) - Determine if an index or an array of indexes exists in accessor;
* [set](#set) - Set a value to accessor;
* [setRef](#setref) - Set a value reference to accessor;
* [setIndex](#setindex) - Set a value to accessor, using index;
* [setIndexRef](#setindexref) - Set a value reference to accessor, using index;
* [get](#get) - Get a value or an array of values from accessor;
* [getRef](#getref) - Get a value reference or an array of values reference from accessor;
* [getForce](#getforce) - Get a value or an array of values from accessor. If the key does not exists, it is added to the array;
* [getForceRef](#getforceref) - Get a value reference or an array of values reference from accessor. If the key does not exists, it is added to the array;
* [getArray](#getarray) - Get a value as array or accessor of values as array from accessor;
* [getArrayRef](#getarrayref) - Get a value reference as array or an array of values reference as array from accessor;
* [getArrayForce](#getarrayforce) - Get a value as array or an array of values as array from accessor. If the key does not exists, it is added to the array;
* [getArrayForceRef](#getarrayforceref) - Get a value reference as array from accessor. If the key does not exists, it is added to the array;
* [getIndex](#getindex) - Get a value or an array of values from accessor, using index;
* [getIndexRef](#getindexref) - Get a value reference or an array of values reference from accessor, using index;
* [getIndexForce](#getindexforce) - Get a value or an array of values from accessor, using index. If the index does not exists, it is added to the array;
* [getIndexForceRef](#getindexforceref) - Get a value reference or an array of values reference from accessor, using index. If the index does not exists, it is added to the array;
* [getIndexArray](#getindexarray) - Get a value as array or an array of values as array from accessor, using index;
* [getIndexArrayRef](#getindexarrayref) - Get a value reference as array or an array of values reference as array from accessor, using index;
* [getIndexArrayForce](#getindexarrayforce) - Get a value as array or an array of values as array from accessor, using index. If the index does not exists, it is added to the array;
* [getIndexArrayForceRef](#getindexarrayforceref) - Get a value reference as array or an array of values reference as array from accessor, using index. If the index does not exists, it is added to the array;
* [del](#del) - Delete a value or an array of values from accessor;
* [delIndex](#delindex) - Delete a value or an array of values from accessor, using index.

## has

Determine if a key or an array of keys exists in accessor.

```php
has(string|array $key): boolean
```

`$key` - Could be a key or an array of keys.

_Example:_

```php
// accessor: ['foo' => 'FOO', 'bar' => 'BAR'];

$storage->has('foo'); // result: true
```

## hasIndex

Determine if an index or an array of indexes exists in accessor.

```php
hasIndex(string|array $index, string $delimiter = self::INDEX_DELIMITER): boolean
```

`$index` - Could be an index or an array of indexes;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => 'bar' => 'BAR'];

$storage->hasIndex('foo.bar'); // result: true
```

## set

Set a value to accessor.

```php
set(string $key, mixed $value): array
```

`$key` - Key;  
`$value` - Value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->set('bar', 'BAR'); // result: ['foo' => 'FOO', 'bar' => 'BAR']
```

## setRef

Set a value reference to accessor.

```php
setRef(string $key, mixed &$value): array
```

`$key` - Key;  
`$value` - Value reference.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$bar = 'BAR';

$storage->setRef('bar', $bar); // result: ['foo' => 'FOO', 'bar' => 'BAR']

$bar = 'BAR2';

// accessor: ['foo' => 'FOO', 'bar' => 'BAR2'];
```

## setIndex

Set a value to accessor, using index.

```php
setIndex(string $index, mixed $value, string $delimiter = self::INDEX_DELIMITER): array
```

`$index` - Index;  
`$value` - Value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->setIndex('bar.baz', 'BAZ'); // result: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ']]
```

## setIndexRef

Set a value reference to accessor, using index.

```php
setIndexRef(string $index, mixed &$value, string $delimiter = self::INDEX_DELIMITER): array
```

`$index` - Index;  
`$value` - Value reference;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$baz = 'BAZ';

$storage->setIndexRef('bar.baz', $baz); // result: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ']]

$baz = 'BAZ2';

// accessor: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ2']];
```

## get

Get a value or an array of values from accessor.

```php
get(string|array $key, mixed|array<mixed> $else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->get('foo'); // result: FOO
```

## getRef

Get a value reference or an array of values reference from accessor.

```php
getRef(string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$foo = &$storage->getRef('foo'); // result: FOO

$foo = 'FOO2';

// accessor: ['foo' => 'FOO2']
```

## getForce

Get a value or an array of values from accessor.
If the key does not exists, it is added to the array.

```php
getForce(string|array $key, mixed|array<mixed> $else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->getForce('bar'); // result: null

// accessor: ['foo' => 'FOO', 'bar' => null]
```

## getForceRef

Get a value reference or an array of values reference from accessor.
If the key does not exists, it is added to the array.

```php
getForceRef(string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$bar = &$storage->getForceRef('bar'); // result: null

$bar = 'BAR';

// accessor: ['foo' => 'FOO', 'bar' => 'BAR']
```

## getArray

Get a value as array or an array of values as array from accessor.

```php
getArray(string|array $key, mixed|array<mixed> $else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->getArray('foo'); // result: ['FOO']
```

## getArrayRef

Get a value reference as array or an array of values reference as array from accessor.

```php
getArrayRef(string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$foo = &$storage->getArrayRef('foo'); // result: ['FOO']

// accessor: ['foo' => ['FOO']]

$foo[0] = 'FOO2';

// accessor: ['foo' => ['FOO2']]
```

## getArrayForce

Get a value as array or an array of values as array from accessor.
If the key does not exists, it is added to the array.

```php
getArrayForce(string|array $key, mixed|array<mixed> $else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->getArrayForce('bar'); // result: []

// accessor: ['foo' => 'FOO', 'bar' => []]
```

## getArrayForceRef

Get a value reference as array or an array of values reference as array from accessor.
If the key does not exists, it is added to the array.

```php
getArrayForceRef(string|array $key, mixed|array<mixed> &$else = null): mixed
```

`$key` - Key;  
`$else` - If the key does not exists, return this value.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$bar = &$storage->getArrayForceRef('bar'); // result: []

$bar[0] = 'BAR';

// accessor: ['foo' => 'FOO', 'bar' => ['BAR']]
```

## getIndex

Get a value or an array of values from accessor, using index.

```php
getIndex(string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => ['bar' => 'BAR']];

$storage->getIndex('foo.bar'); // result: BAR
```

## getIndexRef

Get a value reference or an array of values reference from accessor, using index.

```php
getIndexRef(string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => ['bar' => 'BAR']];

$bar = &$storage->getIndexRef('foo.bar'); // result: BAR

$bar = 'BAR2';

// accessor: ['foo' => ['bar' => 'BAR2']]
```

## getIndexForce

Get a value or an array of values from accessor, using index. If the index does not exists, it is added to the array.

```php
getIndexForce(string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->getIndexForce('bar.baz'); // result: null

// accessor: ['foo' => 'FOO', 'bar' => ['baz' => null]]
```

## getIndexForceRef

Get a value reference or an array of values reference from accessor, using index. If the index does not exists, it is added to the array.

```php
getIndexForceRef(string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$baz = &$storage->getIndexForceRef('bar.baz'); // result: null

$baz = 'BAZ';

// accessor: ['foo' => 'FOO', 'bar' => ['baz' => 'BAZ']]
```

## getIndexArray

Get a value as array or an array of values as array from accessor, using index.

```php
getIndexArray(string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => ['bar' => 'BAR']];

$storage->getIndexArray('foo.bar'); // result: ['BAR']
```

## getIndexArrayRef

Get a value reference as array or an array of values reference as array from accessor, using index.

```php
getIndexArrayRef(string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => ['bar' => 'BAR']];

$foo = &$storage->getIndexArrayRef('foo.bar'); // result: ['BAR']

// accessor: ['foo' => ['bar' => ['BAR']]]

$foo[0] = 'BAR2';

// accessor: ['foo' => ['bar' => ['BAR2']]]
```

## getIndexArrayForce

Get a value as array or an array of values as array from accessor, using index. If the index does not exists, it is added to the array.

```php
getIndexArrayForce(string|array $index, mixed|array<mixed> $else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->getIndexArrayForce('bar.baz'); // result: []

// accessor: ['foo' => 'FOO', 'bar' => ['baz' => []]]
```

## getIndexArrayForceRef

Get a value reference as array or an array of values reference as array from accessor, using index. If the index does not exists, it is added to the array.

```php
getIndexArrayForceRef(string|array $index, mixed|array<mixed> &$else = null, string $delimiter = self::INDEX_DELIMITER): mixed
```

`$index` - Index;  
`$else` - If the index does not exists, return this value;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$baz = &$storage->getIndexArrayForceRef('bar.baz'); // result: []

$baz[0] = 'BAZ';

// accessor: ['foo' => 'FOO', 'bar' => ['baz' => ['BAZ']]]
```

## del

Delete a value or an array of values from accessor.

```php
del(string|array $key): array
```

`$key` - Key.

_Example:_

```php
// accessor: ['foo' => 'FOO'];

$storage->del('foo'); // result: []
```

## delIndex

Delete a value or an array of values from accessor, using index.

```php
delIndex(string|array $index, string $delimiter = self::INDEX_DELIMITER): array
```

`$index` - Index;  
`$delimiter` - Index delimiter.

_Example:_

```php
// accessor: ['foo' => ['bar' => 'BAR']];

$storage->del('foo.bar'); // result: ['foo' => []]
```
