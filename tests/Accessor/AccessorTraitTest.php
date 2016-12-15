<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\AccessorTrait;
use PHPUnit\Framework\TestCase;

abstract class TestingAccessorTrait
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
}

class TestingAccessor extends TestingAccessorTrait
{
}

class AccessorTraitTest extends TestCase
{
    /** @var TestingAccessor */
    private $accessor = null;

    public function setUp()
    {
        parent::setUp();

        $this->accessor = new TestingAccessor();
    }

    public function testEmptyAccessor()
    {
        $this->assertEquals([], $this->accessor->_getAccessor());
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testReferenceAccessor()
    {
        $this->accessor->_getAccessor()['foo'] = 'bar';

        $this->assertEquals(['foo' => 'bar'], $this->accessor->_getAccessor());
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testSetAccessor()
    {
        $accessor = [1, 2, 3];

        $this->accessor->_setAccessor($accessor);

        $this->assertEquals($accessor, $this->accessor->_getAccessor());
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testInAccessor()
    {
        $this->accessor->_setAccessor(['foo' => 'bar']);

        $this->assertArrayHasKey('foo', $this->accessor->_getAccessor());
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testGetFromAccessor()
    {
        $this->accessor->_setAccessor(['foo' => 'bar']);

        $this->assertEquals('bar', $this->accessor->_getFromAccessor('foo'));
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testSetToAccessor()
    {
        $this->accessor->_setAccessor(['foo' => 'bar']);

        $this->accessor->_setToAccessor('foo1', 'bar1');

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], $this->accessor->_getAccessor());
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testAddToAccessor()
    {
        $this->accessor->_setAccessor(['foo' => 'bar', 'foo1' => 'bar1']);

        $this->accessor->_addToAccessor(['foo' => 'bar', 'foo2' => 'bar2']);

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1', 'foo2' => 'bar2'], $this->accessor->_getAccessor());
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testRemoveFromAccessor()
    {
        $this->accessor->_setAccessor(['foo' => 'bar']);

        $this->accessor->_removeFromAccessor('foo');

        $this->assertEquals([], $this->accessor->_getAccessor());
    }

    /**
     * @depends testEmptyAccessor
     */
    public function testResetAccessor()
    {
        $this->accessor->_setAccessor(['foo' => 'bar']);

        $this->accessor->_resetAccessor();

        $this->assertEquals([], $this->accessor->_getAccessor());
    }
}
