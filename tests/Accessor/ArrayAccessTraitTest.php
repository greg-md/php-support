<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\ArrayAccessStaticTrait;
use Greg\Support\Accessor\ArrayAccessTrait;
use Greg\Support\Tests\TestingAccessorTrait;
use PHPUnit\Framework\TestCase;

class TestingArrayAccess implements \ArrayAccess
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
    use TestingAccessorTrait;

    /**
     * @var TestingArrayAccess
     */
    private $arrayAccess = null;

    public function setUp()
    {
        parent::setUp();

        $this->arrayAccess = new TestingArrayAccess();

        //

        $accessor = &TestingArrayAccessStatic::accessor();

        $accessor = [];
    }

    protected function object()
    {
        return $this->arrayAccess;
    }

    protected function &accessor()
    {
        return $this->arrayAccess->accessor();
    }

    protected function staticObject()
    {
        return TestingArrayAccessStatic::class;
    }

    protected function &staticAccessor()
    {
        return TestingArrayAccessStatic::accessor();
    }

    public function testOffsetExists()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        $this->assertTrue(isset($this->arrayAccess['foo']));
    }

    public function testOffsetSet()
    {
        $this->arrayAccess['foo'] = 'bar';

        $this->assertEquals('bar', $this->arrayAccess['foo']);
    }

    public function testOffsetUnset()
    {
        $this->arrayAccess->accessor()['foo'] = 'bar';

        unset($this->arrayAccess['foo']);

        $this->assertEquals([], $this->arrayAccess->accessor());
    }
}
