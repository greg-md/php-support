# SerializableTrait Documentation

A trait for [`\Serializable`](http://php.net/manual/en/class.serializable.php) interface.

_Example:_

```php
class Storage implements \Serializable
{
    private $storage = [];

    use \Greg\Support\Accessor\SerializableTrait;

    private function &getAccessor()
    {
        return $this->storage;
    }
    
    private function setAccessor(array $accessor)
    {
        $this->storage = $accessor;
        
        return $this;
    }
}
```

# Table of contents:

* [Methods](#methods)

# Methods:

Includes [`\Serializable`](http://php.net/manual/en/class.serializable.php) methods.
