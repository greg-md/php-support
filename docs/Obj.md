# Object Documentation

`\Greg\Support\Obj` is working with objects.

# Methods:

* [call](#call) - Determine if a key or an array of keys exists in an array;

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
