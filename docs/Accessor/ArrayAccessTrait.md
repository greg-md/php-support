# ArrayAccessTrait Documentation

A trait for **public** usage of the storage in a class with [`\ArrayAccess`](http://php.net/manual/en/class.arrayaccess.php) support.

Use: [`\Greg\Support\Accessor\AccessorTrait`](AccessorTrait.md), [`\Greg\Support\Accessor\ArrayAccessorTrait`](ArrayAccessorTrait.md).

_Example:_

```php
class Storage implements \ArrayAccess
{
    use \Greg\Support\Accessor\ArrayAccessTrait;
}

$storage = new Storage();
```

# Methods:

See trait uses.
