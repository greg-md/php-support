# Object Documentation

`\Greg\Support\Obj` is working with objects.

# Methods:

* [call](#call) - Call a callable with arguments;
* [callRef](#callRef) - Call a callable with arguments reference;
* [callMixed](#callMixed) - Call a callable with mixed arguments. You don't care anymore of arguments order;
* [callMixedRef](#callMixedRef) - Call a callable with mixed arguments reference. You don't care anymore of arguments order;
* [baseName](#baseName) - Get basename of a class;
* [exists](#exists) - Determine if a class exists;
* [uses](#uses) - Get all uses of a class;
* [usesRecursive](#usesRecursive) - Get all uses of a class and its parents;

## call

Call a callable with arguments.

```php
call(callable(...$args): mixed $callable, ...$args): mixed
```

`$callable` - Callable;  
&nbsp;&nbsp;&nbsp;&nbsp;`...$args` - Arguments that was set in `...$args`;  
`...$args` - Callable arguments.

_Example:_

```php
\Greg\Support\Obj::call(function($foo) { return $foo; }, 'foo'); // result: foo
```

## callRef

Call a callable with arguments reference. See [call](#call) method.

## callMixed

Call a callable with mixed arguments. You don't care anymore of arguments order.

```php
callMixed(callable(...$args): mixed $callable, ...$args): mixed
```

`$callable` - Callable;  
&nbsp;&nbsp;&nbsp;&nbsp;`...$args` - Arguments that was set in `...$args`;  
`...$args` - Callable arguments.

_Example:_

```php

class Foo
{
}

$foo = new Foo();

\Greg\Support\Obj::callMixed(function (Foo $foo, $one, $two, $three = 3) { return func_get_args(); }, 1, $foo, 2); // result: [Foo, 1, 2]
```

## callMixedRef

Call a callable with mixed arguments reference. See [callMixed](#callmixed) method.

## baseName

Get basename of a class.

```php
baseName(string|object $class): string
```

`$class` - The class.

_Example:_

```php
\Greg\Support\Obj::baseName(Foo\Bar::class); // result: Bar
```

## exists

Determine if a class exists.

```php
exists(string|array $name, string|array $prefix = null, string|array $suffix = null): boolean
```

`$name` - Name or name parts as array;  
`$prefix` - Prefix;  
`$suffix` - Suffix.

_Example:_

```php
// Let say we have a class \Foo\BarStrategy
\Greg\Support\Obj::exists('Bar', 'Foo\\', 'Strategy'); // result: true
```

## uses

Get all uses of a class.

```php
uses(string|object $class): array
```

`$class` - The class.

_Example:_

```php
trait FooTrait
{

}

trait BarTrait
{
    use FooTrait;
}

class Baz
{
    use BarTrait;
}

\Greg\Support\Obj::uses(Baz::class); // result: ['BarTrait' => 'BarTrait', 'FooTrait' => 'FooTrait']
```

## usesRecursive

Get all uses of a class and its parents. See [uses](#uses) method.
