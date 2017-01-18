# Accessor Static Trait Documentation

`\Greg\Support\Accessor\AccessorStaticTrait` is a **private** storage trait for static usage.

# Methods:

* [getAccessor](#getaccessor) - Get storage;
* [setAccessor](#setaccessor) - Set storage;
* [inAccessor](#inAccessor) - Check if a key exists in storage;

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

`$key` - It could be a key or an array of keys.
