<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\AccessorStaticTrait;
use PHPUnit\Framework\TestCase;

abstract class TestingAccessorStaticTrait
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
}

class TestingAccessorStatic extends TestingAccessorStaticTrait
{
    public static $accessor = [];
}

class AccessorStaticTraitTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        TestingAccessorStatic::$accessor = [];
    }

    public function testNewAccessor()
    {
        $this->assertEquals([], TestingAccessorStatic::_getAccessor());
    }

    /**
     * @depends testNewAccessor
     */
    public function testReferenceAccessor()
    {
        TestingAccessorStatic::_getAccessor()['foo'] = 'bar';

        $this->assertEquals(['foo' => 'bar'], TestingAccessorStatic::_getAccessor());
    }

    /**
     * @depends testNewAccessor
     */
    public function testSetAccessor()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals($accessor, TestingAccessorStatic::_setAccessor($accessor));
    }

    /**
     * @depends testNewAccessor
     */
    public function testInAccessor()
    {
        $this->assertArrayHasKey('foo', TestingAccessorStatic::_setAccessor(['foo' => 'bar']));
    }

    /**
     * @depends testNewAccessor
     */
    public function testGetFromAccessor()
    {
        TestingAccessorStatic::_setAccessor(['foo' => 'bar']);

        $this->assertEquals('bar', TestingAccessorStatic::_getFromAccessor('foo'));
    }

    /**
     * @depends testNewAccessor
     */
    public function testSetToAccessor()
    {
        TestingAccessorStatic::_setAccessor(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], TestingAccessorStatic::_setToAccessor('foo1', 'bar1'));
    }

    /**
     * @depends testNewAccessor
     */
    public function testAddToAccessor()
    {
        TestingAccessorStatic::_setAccessor(['foo' => 'bar', 'foo1' => 'bar1']);

        $this->assertEquals(
            ['foo' => 'bar', 'foo1' => 'bar1', 'foo2' => 'bar2'],
            TestingAccessorStatic::_addToAccessor(['foo' => 'bar', 'foo2' => 'bar2'])
        );
    }

    /**
     * @depends testNewAccessor
     */
    public function testRemoveFromAccessor()
    {
        TestingAccessorStatic::_setAccessor(['foo' => 'bar']);

        $this->assertEquals([], TestingAccessorStatic::_removeFromAccessor('foo'));
    }

    /**
     * @depends testNewAccessor
     */
    public function testResetAccessor()
    {
        TestingAccessorStatic::_setAccessor(['foo' => 'bar']);

        TestingAccessorStatic::_resetAccessor();

        $this->assertEquals([], TestingAccessorStatic::$accessor);
    }
}
