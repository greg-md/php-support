# ArrayAccessTrait Documentation

`\Greg\Support\Accessor\ArrayAccessTrait` is a trait for **public** usage of the storage in a class
    with [`\ArrayAccess`](http://php.net/manual/en/class.arrayaccess.php) support.

Uses: [`\Greg\Support\Accessor\AccessorTrait`](AccessorTrait.md),
      [`\Greg\Support\Accessor\ArrayAccessorTrait`](ArrayAccessorTrait.md).

_Example:_

```php
class Storage implements \ArrayAccess
{
    use \Greg\Support\Accessor\ArrayAccessTrait;
}
```

# Table of contents:

* [Methods](#methods)

# Methods:

Includes [AccessorTrait](AccessorTrait.md),
         [ArrayAccessorTrait](ArrayAccessorTrait.md)
         and [`\ArrayAccess`](http://php.net/manual/en/class.arrayaccess.php) methods.
