<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\ArrayAccessStaticTrait;
use Greg\Support\Accessor\ArrayAccessTrait;
use PHPUnit\Framework\TestCase;

class TestingArrayAccess
{
    use ArrayAccessTrait;

    public function &accessor()
    {
        return $this->accessor;
    }
}

class TestingArrayAccessStatic
{
    use ArrayAccessStaticTrait;

    public static function &accessor()
    {
        return static::$accessor;
    }
}

class ArrayAccessTraitTest extends TestCase
{
    /**
     * @var TestingArrayAccess
     */
    private $arrayAccess = null;

    public function setUp()
    {
        parent::setUp();

        $this->arrayAccess = new TestingArrayAccess();

        //

        $accessor = &TestingArrayAccessStatic::accessor(); $accessor = [];
    }

    public function testHas()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertTrue($this->arrayAccess->has('foo'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertTrue(TestingArrayAccessStatic::has('foo'));
    }

    public function testHasNot()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertFalse($this->arrayAccess->has('foo1'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertFalse(TestingArrayAccessStatic::has('foo1'));
    }

    public function testHasIndex()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertTrue($this->arrayAccess->hasIndex('foo.bar'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertTrue(TestingArrayAccessStatic::hasIndex('foo.bar'));
    }

    public function testHasNotIndex()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertFalse($this->arrayAccess->hasIndex('foo.bar1'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertFalse(TestingArrayAccessStatic::hasIndex('foo.bar1'));
    }

    public function testHasIndexDelimiter()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertTrue($this->arrayAccess->hasIndex('foo-bar', '-'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertTrue(TestingArrayAccessStatic::hasIndex('foo-bar', '-'));
    }

    public function testHasNotIndexDelimiter()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertFalse($this->arrayAccess->hasIndex('foo.bar', '-'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertFalse(TestingArrayAccessStatic::hasIndex('foo.bar', '-'));
    }

    public function testSet()
    {
        $this->assertEquals(['foo' => 'bar'], $this->arrayAccess->set('foo', 'bar'));

        //

        $this->assertEquals(['foo' => 'bar'], TestingArrayAccessStatic::set('foo', 'bar'));
    }

    public function testSetRef()
    {
        $value = 'bar';

        $this->arrayAccess->setRef('foo', $value);

        $value = 'biz';

        $this->assertEquals(['foo' => $value], $this->arrayAccess->accessor());

        //

        $value = 'bar';

        TestingArrayAccessStatic::setRef('foo', $value);

        $value = 'biz';

        $this->assertEquals(['foo' => $value], TestingArrayAccessStatic::accessor());
    }

    public function testSetIndex()
    {
        $this->assertEquals(['foo' => ['bar' => 'biz']], $this->arrayAccess->setIndex('foo.bar', 'biz'));

        //

        $this->assertEquals(['foo' => ['bar' => 'biz']], TestingArrayAccessStatic::setIndex('foo.bar', 'biz'));
    }

    public function testSetIndexRef()
    {
        $value = 'biz';

        $this->arrayAccess->setIndexRef('foo.bar', $value);

        $value = 'baz';

        $this->assertEquals(['foo' => ['bar' => $value]], $this->arrayAccess->accessor());

        //

        $value = 'biz';

        TestingArrayAccessStatic::setIndexRef('foo.bar', $value);

        $value = 'baz';

        $this->assertEquals(['foo' => ['bar' => $value]], TestingArrayAccessStatic::accessor());
    }

    public function testGet()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertEquals('bar', $this->arrayAccess->get('foo'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertEquals('bar', TestingArrayAccessStatic::get('foo'));
    }

    public function testGetElse()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertEquals('biz', $this->arrayAccess->get('foo1', 'biz'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertEquals('biz', TestingArrayAccessStatic::get('foo1', 'biz'));
    }

    public function testGetRef()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $value = &$this->arrayAccess->getRef('foo');

        $value = 'biz';

        $this->assertEquals(['foo' => 'biz'], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $value = &TestingArrayAccessStatic::getRef('foo');

        $value = 'biz';

        $this->assertEquals(['foo' => 'biz'], TestingArrayAccessStatic::accessor());
    }

    public function testGetRefElse()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $else = 'biz';

        $value = &$this->arrayAccess->getRef('foo1', $else);

        $value = 'baz';

        $this->assertEquals(['foo' => 'bar'], $this->arrayAccess->accessor());

        $this->assertEquals('baz', $else);

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $else = 'biz';

        $value = &TestingArrayAccessStatic::getRef('foo1', $else);

        $value = 'baz';

        $this->assertEquals(['foo' => 'bar'], TestingArrayAccessStatic::accessor());

        $this->assertEquals('baz', $else);
    }

    public function testGetForce()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertNull($this->arrayAccess->getForce('foo1'));

        $this->assertArrayHasKey('foo1', $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertNull(TestingArrayAccessStatic::getForce('foo1'));

        $this->assertArrayHasKey('foo1', TestingArrayAccessStatic::accessor());
    }

    public function testGetForceRef()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $value = &$this->arrayAccess->getForceRef('foo1');

        $value = 'bar1';

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $value = &TestingArrayAccessStatic::getForceRef('foo1');

        $value = 'bar1';

        $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], TestingArrayAccessStatic::accessor());
    }

    public function testGetArray()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertEquals(['bar'], $this->arrayAccess->getArray('foo'));

        $this->assertEquals(['foo' => 'bar'], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertEquals(['bar'], TestingArrayAccessStatic::getArray('foo'));

        $this->assertEquals(['foo' => 'bar'], TestingArrayAccessStatic::accessor());
    }

    public function testGetArrayRef()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertEquals(['bar'], $this->arrayAccess->getArrayRef('foo'));

        $this->assertEquals(['foo' => ['bar']], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertEquals(['bar'], TestingArrayAccessStatic::getArrayRef('foo'));

        $this->assertEquals(['foo' => ['bar']], TestingArrayAccessStatic::accessor());
    }

    public function testGetArrayForce()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertEquals([], $this->arrayAccess->getArrayForce('foo1'));

        $this->assertArrayHasKey('foo1', $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertEquals([], TestingArrayAccessStatic::getArrayForce('foo1'));

        $this->assertArrayHasKey('foo1', TestingArrayAccessStatic::accessor());
    }

    public function testGetArrayForceRef()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $value = &$this->arrayAccess->getArrayForceRef('foo1');

        $value[] = 'bar1';

        $this->assertEquals(['foo' => 'bar', 'foo1' => ['bar1']], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $value = &TestingArrayAccessStatic::getArrayForceRef('foo1');

        $value[] = 'bar1';

        $this->assertEquals(['foo' => 'bar', 'foo1' => ['bar1']], TestingArrayAccessStatic::accessor());
    }

    public function testGetIndex()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals('biz', $this->arrayAccess->getIndex('foo.bar'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals('biz', TestingArrayAccessStatic::getIndex('foo.bar'));
    }

    public function testGetIndexElse()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals('buz', $this->arrayAccess->getIndex('foo.bar1', 'buz'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals('buz', TestingArrayAccessStatic::getIndex('foo.bar1', 'buz'));
    }

    public function testGetIndexRef()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $value = &$this->arrayAccess->getIndexRef('foo.bar');

        $value = 'buz';

        $this->assertEquals(['foo' => ['bar' => 'buz']], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $value = &TestingArrayAccessStatic::getIndexRef('foo.bar');

        $value = 'buz';

        $this->assertEquals(['foo' => ['bar' => 'buz']], TestingArrayAccessStatic::accessor());
    }

    public function testGetIndexRefElse()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $else = 'buz';

        $value = &$this->arrayAccess->getIndexRef('foo.bar1', $else);

        $value = 'baz';

        $this->assertEquals(['foo' => ['bar' => 'biz']], $this->arrayAccess->accessor());

        $this->assertEquals('baz', $else);

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $else = 'buz';

        $value = &TestingArrayAccessStatic::getIndexRef('foo.bar1', $else);

        $value = 'baz';

        $this->assertEquals(['foo' => ['bar' => 'biz']], TestingArrayAccessStatic::accessor());

        $this->assertEquals('baz', $else);
    }

    public function testGetIndexForce()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertNull($this->arrayAccess->getIndexForce('foo.bar1'));

        $this->assertArrayHasKey('bar1', $this->arrayAccess->accessor()['foo']);

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertNull(TestingArrayAccessStatic::getIndexForce('foo.bar1'));

        $this->assertArrayHasKey('bar1', TestingArrayAccessStatic::accessor()['foo']);
    }

    public function testGetIndexForceRef()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $value = &$this->arrayAccess->getIndexForceRef('foo.bar1');

        $value = 'biz1';

        $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => 'biz1']], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $value = &TestingArrayAccessStatic::getIndexForceRef('foo.bar1');

        $value = 'biz1';

        $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => 'biz1']], TestingArrayAccessStatic::accessor());
    }

    public function testGetIndexArray()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals(['biz'], $this->arrayAccess->getIndexArray('foo.bar'));

        $this->assertEquals(['foo' => ['bar' => 'biz']], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals(['biz'], TestingArrayAccessStatic::getIndexArray('foo.bar'));

        $this->assertEquals(['foo' => ['bar' => 'biz']], TestingArrayAccessStatic::accessor());
    }

    public function testGetIndexArrayRef()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals(['biz'], $this->arrayAccess->getIndexArrayRef('foo.bar'));

        $this->assertEquals(['foo' => ['bar' => ['biz']]], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals(['biz'], TestingArrayAccessStatic::getIndexArrayRef('foo.bar'));

        $this->assertEquals(['foo' => ['bar' => ['biz']]], TestingArrayAccessStatic::accessor());
    }

    public function testGetIndexArrayForce()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals([], $this->arrayAccess->getIndexArrayForce('foo.bar1'));

        $this->assertArrayHasKey('bar1', $this->arrayAccess->accessor()['foo']);

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals([], TestingArrayAccessStatic::getIndexArrayForce('foo.bar1'));

        $this->assertArrayHasKey('bar1', TestingArrayAccessStatic::accessor()['foo']);
    }

    public function testGetIndexArrayForceRef()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $value = &$this->arrayAccess->getIndexArrayForceRef('foo.bar1');

        $value[] = 'biz1';

        $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => ['biz1']]], $this->arrayAccess->accessor());

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $value = &TestingArrayAccessStatic::getIndexArrayForceRef('foo.bar1');

        $value[] = 'biz1';

        $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => ['biz1']]], TestingArrayAccessStatic::accessor());
    }

    public function testDel()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertEquals([], $this->arrayAccess->del('foo'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = 'bar';

        $this->assertEquals([], TestingArrayAccessStatic::del('foo'));
    }

    public function testDelIndex()
    {
        $this->arrayAccess->accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals(['foo' => []], $this->arrayAccess->delIndex('foo.bar'));

        //

        TestingArrayAccessStatic::accessor()['foo'] = ['bar' => 'biz'];

        $this->assertEquals(['foo' => []], TestingArrayAccessStatic::delIndex('foo.bar'));
    }
}
