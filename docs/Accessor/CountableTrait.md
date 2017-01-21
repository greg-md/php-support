# CountableTrait Documentation

A trait for [Countable](http://php.net/manual/en/class.countable.php) interface.

_Example:_

```php
class Storage implements \Countable
{
    private $storage = [];

    use \Greg\Support\Accessor\CountableTrait;

    private function &getAccessor()
    {
        return $this->storage;
    }
}

$storage = new Storage();

echo $storage->count();
```

# Methods:

See [Countable](http://php.net/manual/en/class.countable.php) interface.
