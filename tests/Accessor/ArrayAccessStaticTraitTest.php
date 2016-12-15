<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\ArrayAccessStaticTrait;
use PHPUnit\Framework\TestCase;

abstract class TestingArrayAccessStaticTrait
{
    use ArrayAccessStaticTrait;
}

class TestingArrayAccessStatic extends TestingArrayAccessStaticTrait
{
    public static $accessor = [];
}

class ArrayAccessStaticTraitTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        TestingArrayAccessStatic::$accessor = [];
    }

    public function testHas()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertTrue(TestingArrayAccessStatic::has('foo'));
    }

    public function testHasNot()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertFalse(TestingArrayAccessStatic::has('foo1'));
    }

    public function testHasIndex()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertTrue(TestingArrayAccessStatic::hasIndex('foo.bar'));
    }

    public function testHasNotIndex()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertFalse(TestingArrayAccessStatic::hasIndex('foo.bar1'));
    }

    public function testHasIndexDelimiter()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertTrue(TestingArrayAccessStatic::hasIndex('foo-bar', '-'));
    }

    public function testHasNotIndexDelimiter()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertFalse(TestingArrayAccessStatic::hasIndex('foo.bar', '-'));
    }

    public function testSet()
    {
        $this->assertEquals(['foo' => 'bar'], TestingArrayAccessStatic::set('foo', 'bar'));
    }

    public function testSetRef()
    {
        $value = 'bar';

        TestingArrayAccessStatic::setRef('foo', $value);

        $value = 'biz';

        $this->assertEquals(['foo' => $value], TestingArrayAccessStatic::$accessor);
    }

    public function testSetIndex()
    {
        $this->assertEquals(['foo' => ['bar' => 'biz']], TestingArrayAccessStatic::setIndex('foo.bar', 'biz'));
    }

    public function testSetIndexRef()
    {
        $value = 'biz';

        TestingArrayAccessStatic::setIndexRef('foo.bar', $value);

        $value = 'baz';

        $this->assertEquals(['foo' => ['bar' => $value]], TestingArrayAccessStatic::$accessor);
    }

    public function testGet()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertEquals('bar', TestingArrayAccessStatic::get('foo'));
    }

    public function testGetElse()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertEquals('biz', TestingArrayAccessStatic::get('foo1', 'biz'));
    }

    public function testGetRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $value = &TestingArrayAccessStatic::getRef('foo');

        $value = 'biz';

        $this->assertEquals(['foo' => 'biz'], TestingArrayAccessStatic::$accessor);
    }

    public function testGetRefElse()
    {
        $else = 'biz';

        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $value = &TestingArrayAccessStatic::getRef('foo1', $else);

        $value = 'baz';

        $this->assertEquals(['foo' => 'bar'], TestingArrayAccessStatic::$accessor);

        $this->assertEquals('baz', $else);
    }

    public function testGetForce()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertNull(TestingArrayAccessStatic::getForce('foo1'));

        $this->assertArrayHasKey('foo1', TestingArrayAccessStatic::$accessor);
    }

    public function testGetForceRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $value = &TestingArrayAccessStatic::getForceRef('foo1');

        $value = 'bar1';

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], TestingArrayAccessStatic::$accessor);
    }

    public function testGetArray()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertEquals(['bar'], TestingArrayAccessStatic::getArray('foo'));

        $this->assertEquals(['foo' => 'bar'], TestingArrayAccessStatic::$accessor);
    }

    public function testGetArrayRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertEquals(['bar'], TestingArrayAccessStatic::getArrayRef('foo'));

        $this->assertEquals(['foo' => ['bar']], TestingArrayAccessStatic::$accessor);
    }

    public function testGetArrayForce()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertEquals([], TestingArrayAccessStatic::getArrayForce('foo1'));

        $this->assertArrayHasKey('foo1', TestingArrayAccessStatic::$accessor);
    }

    public function testGetArrayForceRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $value = &TestingArrayAccessStatic::getArrayForceRef('foo1');

        $value[] = 'bar1';

        $this->assertEquals(['foo' => 'bar', 'foo1' => ['bar1']], TestingArrayAccessStatic::$accessor);
    }

    public function testGetIndex()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertEquals('biz', TestingArrayAccessStatic::getIndex('foo.bar'));
    }

    public function testGetIndexElse()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertEquals('buz', TestingArrayAccessStatic::getIndex('foo.bar1', 'buz'));
    }

    public function testGetIndexRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $value = &TestingArrayAccessStatic::getIndexRef('foo.bar');

        $value = 'buz';

        $this->assertEquals(['foo' => ['bar' => 'buz']], TestingArrayAccessStatic::$accessor);
    }

    public function testGetIndexRefElse()
    {
        $else = 'buz';

        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $value = &TestingArrayAccessStatic::getIndexRef('foo.bar1', $else);

        $value = 'baz';

        $this->assertEquals(['foo' => ['bar' => 'biz']], TestingArrayAccessStatic::$accessor);

        $this->assertEquals('baz', $else);
    }

    public function testGetIndexForce()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertNull(TestingArrayAccessStatic::getIndexForce('foo.bar1'));

        $this->assertArrayHasKey('bar1', TestingArrayAccessStatic::$accessor['foo']);
    }

    public function testGetIndexForceRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $value = &TestingArrayAccessStatic::getIndexForceRef('foo.bar1');

        $value = 'biz1';

        $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => 'biz1']], TestingArrayAccessStatic::$accessor);
    }

    public function testGetIndexArray()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => ['bar' => 'biz']];

        $this->assertEquals(['biz'], TestingArrayAccessStatic::getIndexArray('foo.bar'));

        $this->assertEquals(['foo' => ['bar' => 'biz']], TestingArrayAccessStatic::$accessor);
    }

    /*

    public function testGetArrayRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertEquals(['bar'], TestingArrayAccessStatic::getArrayRef('foo'));

        $this->assertEquals(['foo' => ['bar']], TestingArrayAccessStatic::$accessor);
    }

    public function testGetArrayForce()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $this->assertEquals([], TestingArrayAccessStatic::getArrayForce('foo1'));

        $this->assertArrayHasKey('foo1', TestingArrayAccessStatic::$accessor);
    }

    public function testGetArrayForceRef()
    {
        TestingArrayAccessStatic::$accessor = ['foo' => 'bar'];

        $value = &TestingArrayAccessStatic::getArrayForceRef('foo1');

        $value[] = 'bar1';

        $this->assertEquals(['foo' => 'bar', 'foo1' => ['bar1']], TestingArrayAccessStatic::$accessor);
    }
    */
}