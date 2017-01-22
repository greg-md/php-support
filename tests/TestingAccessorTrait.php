<?php

namespace Greg\Support\Tests;

use Greg\Support\Accessor\ArrayAccessStaticTrait;
use Greg\Support\Accessor\ArrayAccessTrait;

trait TestingAccessorTrait
{
    /** @test */
    public function accessor_it_checks_if_has_value()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $this->assertTrue($object->has('foo'));

            $this->assertFalse($object->has('foo1'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $this->assertTrue($staticObject::has('foo'));

            $this->assertFalse($staticObject::has('foo1'));
        }
    }

    /** @test */
    public function accessor_it_checks_if_has_value_by_index()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $this->assertTrue($object->hasIndex('foo.bar'));

            $this->assertFalse($object->hasIndex('foo.bar1'));

            $this->assertTrue($object->hasIndex('foo-bar', '-'));

            $this->assertFalse($object->hasIndex('foo.bar', '-'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $this->assertTrue($staticObject::hasIndex('foo.bar'));

            $this->assertFalse($staticObject::hasIndex('foo.bar1'));

            $this->assertTrue($staticObject::hasIndex('foo-bar', '-'));

            $this->assertFalse($staticObject::hasIndex('foo.bar', '-'));
        }
    }

    /** @test */
    public function accessor_it_sets_value()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->assertEquals(['foo' => 'bar'], $object->set('foo', 'bar'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->assertEquals(['foo' => 'bar'], $staticObject::set('foo', 'bar'));
        }
    }

    /** @test */
    public function accessor_it_sets_value_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $value = 'bar';

            $object->setRef('foo', $value);

            $value = 'biz';

            $this->assertEquals(['foo' => $value], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $value = 'bar';

            $staticObject::setRef('foo', $value);

            $value = 'biz';

            $this->assertEquals(['foo' => $value], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_sets_value_by_index()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->assertEquals(['foo' => ['bar' => 'biz']], $object->setIndex('foo.bar', 'biz'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->assertEquals(['foo' => ['bar' => 'biz']], $staticObject::setIndex('foo.bar', 'biz'));
        }
    }

    /** @test */
    public function accessor_it_sets_value_by_index_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $value = 'biz';

            $object->setIndexRef('foo.bar', $value);

            $value = 'baz';

            $this->assertEquals(['foo' => ['bar' => $value]], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $value = 'biz';

            $staticObject::setIndexRef('foo.bar', $value);

            $value = 'baz';

            $this->assertEquals(['foo' => ['bar' => $value]], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_value()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $this->assertEquals('bar', $object->get('foo'));

            $this->assertEquals('biz', $object->get('foo1', 'biz'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $this->assertEquals('bar', $staticObject::get('foo'));

            $this->assertEquals('biz', $staticObject::get('foo1', 'biz'));
        }
    }

    /** @test */
    public function accessor_it_gets_value_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $value = &$object->getRef('foo');

            $value = 'biz';

            $this->assertEquals(['foo' => 'biz'], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $value = &$staticObject::getRef('foo');

            $value = 'biz';

            $this->assertEquals(['foo' => 'biz'], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_else_value_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $else = 'biz';

            $value = &$object->getRef('foo1', $else);

            $value = 'baz';

            $this->assertEquals(['foo' => 'bar'], $this->accessor());

            $this->assertEquals('baz', $else);
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $else = 'biz';

            $value = &$staticObject::getRef('foo1', $else);

            $value = 'baz';

            $this->assertEquals(['foo' => 'bar'], $this->staticAccessor());

            $this->assertEquals('baz', $else);
        }
    }

    /** @test */
    public function accessor_it_gets_force()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $this->assertNull($object->getForce('foo1'));

            $this->assertArrayHasKey('foo1', $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $this->assertNull($staticObject::getForce('foo1'));

            $this->assertArrayHasKey('foo1', $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_force_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $value = &$object->getForceRef('foo1');

            $value = 'bar1';

            $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $value = &$staticObject::getForceRef('foo1');

            $value = 'bar1';

            $this->assertEquals(['foo' => 'bar', 'foo1' => 'bar1'], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_array()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $this->assertEquals(['bar'], $object->getArray('foo'));

            $this->assertEquals(['foo' => 'bar'], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $this->assertEquals(['bar'], $staticObject::getArray('foo'));

            $this->assertEquals(['foo' => 'bar'], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_array_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $this->assertEquals(['bar'], $object->getArrayRef('foo'));

            $this->assertEquals(['foo' => ['bar']], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $this->assertEquals(['bar'], $staticObject::getArrayRef('foo'));

            $this->assertEquals(['foo' => ['bar']], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_array_force()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $this->assertEquals([], $object->getArrayForce('foo1'));

            $this->assertArrayHasKey('foo1', $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $this->assertEquals([], $staticObject::getArrayForce('foo1'));

            $this->assertArrayHasKey('foo1', $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_array_force_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $value = &$object->getArrayForceRef('foo1');

            $value[] = 'bar1';

            $this->assertEquals(['foo' => 'bar', 'foo1' => ['bar1']], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $value = &$staticObject::getArrayForceRef('foo1');

            $value[] = 'bar1';

            $this->assertEquals(['foo' => 'bar', 'foo1' => ['bar1']], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_index()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals('biz', $object->getIndex('foo.bar'));

            $this->assertEquals('buz', $object->getIndex('foo.bar1', 'buz'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals('biz', $staticObject::getIndex('foo.bar'));

            $this->assertEquals('buz', $staticObject::getIndex('foo.bar1', 'buz'));
        }
    }

    /** @test */
    public function accessor_it_gets_index_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $value = &$object->getIndexRef('foo.bar');

            $value = 'buz';

            $this->assertEquals(['foo' => ['bar' => 'buz']], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $value = &$staticObject::getIndexRef('foo.bar');

            $value = 'buz';

            $this->assertEquals(['foo' => ['bar' => 'buz']], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_index_else_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $else = 'buz';

            $value = &$object->getIndexRef('foo.bar1', $else);

            $value = 'baz';

            $this->assertEquals(['foo' => ['bar' => 'biz']], $this->accessor());

            $this->assertEquals('baz', $else);
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $else = 'buz';

            $value = &$staticObject::getIndexRef('foo.bar1', $else);

            $value = 'baz';

            $this->assertEquals(['foo' => ['bar' => 'biz']], $this->staticAccessor());

            $this->assertEquals('baz', $else);
        }
    }

    /** @test */
    public function accessor_it_gets_index_force()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $this->assertNull($object->getIndexForce('foo.bar1'));

            $this->assertArrayHasKey('bar1', $this->accessor()['foo']);
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $this->assertNull($staticObject::getIndexForce('foo.bar1'));

            $this->assertArrayHasKey('bar1', $this->staticAccessor()['foo']);
        }
    }

    /** @test */
    public function accessor_it_gets_index_force_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $value = &$object->getIndexForceRef('foo.bar1');

            $value = 'biz1';

            $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => 'biz1']], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $value = &$staticObject::getIndexForceRef('foo.bar1');

            $value = 'biz1';

            $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => 'biz1']], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_index_array()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals(['biz'], $object->getIndexArray('foo.bar'));

            $this->assertEquals(['foo' => ['bar' => 'biz']], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals(['biz'], $staticObject::getIndexArray('foo.bar'));

            $this->assertEquals(['foo' => ['bar' => 'biz']], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_index_array_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals(['biz'], $object->getIndexArrayRef('foo.bar'));

            $this->assertEquals(['foo' => ['bar' => ['biz']]], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals(['biz'], $staticObject::getIndexArrayRef('foo.bar'));

            $this->assertEquals(['foo' => ['bar' => ['biz']]], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_gets_index_array_force()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals([], $object->getIndexArrayForce('foo.bar1'));

            $this->assertArrayHasKey('bar1', $this->accessor()['foo']);
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals([], $staticObject::getIndexArrayForce('foo.bar1'));

            $this->assertArrayHasKey('bar1', $this->staticAccessor()['foo']);
        }
    }

    /** @test */
    public function accessor_it_gets_index_array_force_by_reference()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $value = &$object->getIndexArrayForceRef('foo.bar1');

            $value[] = 'biz1';

            $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => ['biz1']]], $this->accessor());
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $value = &$staticObject::getIndexArrayForceRef('foo.bar1');

            $value[] = 'biz1';

            $this->assertEquals(['foo' => ['bar' => 'biz', 'bar1' => ['biz1']]], $this->staticAccessor());
        }
    }

    /** @test */
    public function accessor_it_deletes_by_key()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = 'bar';

            $this->assertEquals([], $object->removeIndex('foo'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = 'bar';

            $this->assertEquals([], $staticObject::removeIndex('foo'));
        }
    }

    /** @test */
    public function accessor_it_deletes_by_index()
    {
        $this->testingAccessorSetup();

        if ($object = $this->object()) {
            $this->accessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals(['foo' => []], $object->removeIndex('foo.bar'));
        }

        //

        if ($staticObject = $this->staticObject()) {
            $this->staticAccessor()['foo'] = ['bar' => 'biz'];

            $this->assertEquals(['foo' => []], $staticObject::removeIndex('foo.bar'));
        }
    }

    public function testingAccessorSetup()
    {
    }

    /**
     * @return ArrayAccessTrait|null
     */
    protected function object()
    {
        return null;
    }

    protected function &accessor()
    {
        $empty = [];

        return $empty;
    }

    /**
     * @return ArrayAccessStaticTrait|null
     */
    protected function staticObject()
    {
        return null;
    }

    protected function &staticAccessor()
    {
        $empty = [];

        return $empty;
    }
}
