# AccessorStaticTrait Documentation

`\Greg\Support\Accessor\AccessorStaticTrait` is a **private** storage trait for static usage.
You don't care anymore about setting a storage variable and creating base methods for using it. 

_Example:_

```php
class InMemory
{
    use \Greg\Support\Accessor\AccessorStaticTrait;

    public static function get($key)
    {
        return static::getFromAccessor($key);
    }

    public static function set($key, $value)
    {
        return static::setToAccessor($key, $value);
    }
}
```

# Methods:

* [getAccessor](#getaccessor) - Get storage;
* [setAccessor](#setaccessor) - Set storage;
* [inAccessor](#inaccessor) - Determine if keys exists in storage;
* [getFromAccessor](#getfromaccessor) - Get values from storage;
* [setToAccessor](#settoaccessor) - Set a value to storage;
* [addToAccessor](#addtoaccessor) - Add values to storage;
* [removeFromAccessor](#removefromaccessor) - Remove values from storage;
* [resetAccessor](#resetaccessor) - Cleanup storage.

## getAccessor

Get storage.

```php
&getAccessor(): array
```

## setAccessor

Set storage.

```php
setAccessor(array $accessor): array
```

`$accessor` - Storage.

## inAccessor

Set storage.

```php
inAccessor(string|array $key): boolean
```

`$key` - Could be a key or an array of keys.

## getFromAccessor

Get values from storage.

```php
getFromAccessor(string|array $key, string|array $else = null): mixed
```

`$key` - Could be a key or an array of keys;  
`$else` - If values not found, will return this. Could be a key or an array of keys.

## setToAccessor

Set a value to storage.

```php
setToAccessor(string $key, mixed $value): array
```

`$key` - Key;  
`$value` - Value.

## addToAccessor

Add values to storage.

```php
addToAccessor(array $values): array
```

`$values` - Values. Key-Value pair.

## removeFromAccessor

Remove values from storage.

```php
removeFromAccessor(string|array $key): array
```

`$key` - Could be a key or an array of keys.

## resetAccessor

Cleanup storage.

```php
resetAccessor(): array
```
