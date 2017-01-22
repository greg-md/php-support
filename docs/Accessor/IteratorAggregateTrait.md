# IteratorAggregateTrait Documentation

A trait for [`\IteratorAggregate`](http://php.net/manual/en/class.iteratoraggregate.php) interface.

_Example:_

```php
class Storage implements \IteratorAggregate
{
    private $storage = [];

    use \Greg\Support\Accessor\IteratorAggregateTrait;

    private function &getAccessor()
    {
        return $this->storage;
    }
}
```

# Table of contents:

* [Methods](#methods)

# Methods:

Includes [`\IteratorAggregate`](http://php.net/manual/en/class.iteratoraggregate.php) methods.

* [getIteratorClass](#getiteratorclass) - Get iterator class;
* [setIteratorClass](#setiteratorclass) - Set iterator class.

**Methods description is under construction.**
