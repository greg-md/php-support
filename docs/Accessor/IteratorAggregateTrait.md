# IteratorAggregateTrait Documentation

A trait for [IteratorAggregate](http://php.net/manual/en/class.iteratoraggregate.php) interface.

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

# Methods:

See [IteratorAggregate](http://php.net/manual/en/class.iteratoraggregate.php) interface.

* [getIteratorClass](#getIteratorClass) - Get iterator class;
* [setIteratorClass](#setIteratorClass) - Set iterator class;
