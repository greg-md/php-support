<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\AccessorStaticTrait;
use Greg\Support\Accessor\AccessorTrait;
use PHPUnit\Framework\TestCase;

class TestingAccessor
{
    use AccessorTrait;

    public function &_getAccessor()
    {
        return $this->getAccessor();
    }

    public function _setAccessor(array $accessor)
    {
        return $this->setAccessor($accessor);
    }

    public function _inAccessor($key)
    {
        return $this->inAccessor($key);
    }

    public function _getFromAccessor($key)
    {
        return $this->getFromAccessor($key);
    }

    public function _setToAccessor($key, $value)
    {
        return $this->setToAccessor($key, $value);
    }

    public function _addToAccessor(array $items)
    {
        return $this->addToAccessor($items);
    }

    public function _removeFromAccessor($key)
    {
        return $this->removeFromAccessor($key);
    }

    public function _resetAccessor()
    {
        return $this->resetAccessor();
    }

    public function &accessor()
    {
        return $this->accessor;
    }
}

class TestingAccessorStatic
{
    use AccessorStaticTrait;

    public static function &_getAccessor()
    {
        return static::getAccessor();
    }

    public static function _setAccessor(array $accessor)
    {
        return static::setAccessor($accessor);
    }

    public static function _inAccessor($key)
    {
        return static::inAccessor($key);
    }

    public static function _getFromAccessor($key)
    {
        return static::getFromAccessor($key);
    }

    public static function _setToAccessor($key, $value)
    {
        return static::setToAccessor($key, $value);
    }

    public static function _addToAccessor(array $items)
    {
        return static::addToAccessor($items);
    }

    public static function _removeFromAccessor($key)
    {
        return static::removeFromAccessor($key);
    }

    public static function _resetAccessor()
    {
        return static::resetAccessor();
    }

    public static function &accessor()
    {
        return static::$accessor;
    }
}

class AccessorTraitTest extends TestCase
{
    /**
     * @var TestingAccessor
     */
    private $accessor = null;

    public function setUp()
    {
        parent::setUp();

        $this->accessor = new TestingAccessor();

        //

        $accessor = &TestingAccessorStatic::accessor(); $accessor = [];
    }

    public function testNewAccessor()
    {
        $this->assertEquals([], $this->accessor->accessor());

        //

        $this->assertEquals([], TestingAccessorStatic::accessor());
    }

    public function testReferenceAccessor()
    {
        $this->accessor->_getAccessor()['foo'] = 'bar';

        $this->assertEquals(['foo' => 'bar'], $this->accessor->accessor());

        //

        TestingAccessorStatic::_getAccessor()['foo'] = 'bar';

        $this->assertEquals(['foo' => 'bar'], TestingAccessorStatic::accessor());
    }

    public function testSetAccessor()
    {
        $this->assertEquals([1], $this->accessor->_setAccessor([1]));

        //

        $this->assertEquals([1], TestingAccessorStatic::_setAccessor([1]));
    }

    public function testInAccessor()
    {
        $this->assertArrayHasKey('foo', $this->accessor->_setAccessor(['foo' => 'bar']));

        //

        $this->assertArrayHasKey('foo', TestingAccessorStatic::_setAccessor(['foo' => 'bar']));
    }

    public function testGetFromAccessor()
    {
        $this->accessor->accessor()['foo'] = 'bar';

        $this->assertEquals('bar', $this->accessor->_getFromAccessor('foo'));

        //

        TestingAccessorStatic::accessor()['foo'] = 'bar';

        $this->assertEquals('bar', TestingAccessorStatic::_getFromAccessor('foo'));
    }

    public function testSetToAccessor()
    {
        $this->accessor->accessor()['foo'] = 'bar';

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], $this->accessor->_setToAccessor('foo1', 'bar1'));

        //

        TestingAccessorStatic::accessor()['foo'] = 'bar';

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], TestingAccessorStatic::_setToAccessor('foo1', 'bar1'));
    }

    public function testAddToAccessor()
    {
        $this->accessor->accessor()['foo'] = 'bar';

        $this->accessor->accessor()['foo1'] = 'bar1';

        $this->assertEquals(
            ['foo' => 'bar', 'foo1' => 'bar1', 'foo2' => 'bar2'],
            $this->accessor->_addToAccessor(['foo' => 'bar', 'foo2' => 'bar2'])
        );

        //

        TestingAccessorStatic::accessor()['foo'] = 'bar';

        TestingAccessorStatic::accessor()['foo1'] = 'bar1';

        $this->assertEquals(
            ['foo' => 'bar', 'foo1' => 'bar1', 'foo2' => 'bar2'],
            TestingAccessorStatic::_addToAccessor(['foo' => 'bar', 'foo2' => 'bar2'])
        );
    }

    public function testRemoveFromAccessor()
    {
        $this->accessor->accessor()['foo'] = 'bar';

        $this->assertEquals([], $this->accessor->_removeFromAccessor('foo'));

        //

        TestingAccessorStatic::accessor()['foo'] = 'bar';

        $this->assertEquals([], TestingAccessorStatic::_removeFromAccessor('foo'));
    }

    public function testResetAccessor()
    {
        $this->accessor->accessor()['foo'] = 'bar';

        $this->assertEquals([], $this->accessor->_resetAccessor());

        //

        TestingAccessorStatic::accessor()['foo'] = 'bar';

        $this->assertEquals([], TestingAccessorStatic::_resetAccessor());
    }
}
