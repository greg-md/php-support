# SerializableTrait Documentation

A trait for [SerializableTrait](http://php.net/manual/en/class.serializable.php) interface.

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

# Methods:

See [SerializableTrait](http://php.net/manual/en/class.serializable.php) interface.
