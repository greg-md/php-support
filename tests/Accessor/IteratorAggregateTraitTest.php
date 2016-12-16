<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\IteratorAggregateTrait;
use PHPUnit\Framework\TestCase;

class TestingIteratorAggregate
{
    protected $accessor = [];

    use IteratorAggregateTrait;

    private function &getAccessor()
    {
        return $this->accessor;
    }
}

class CustomArrayIterator extends \ArrayIterator
{
}

class IteratorAggregateTraitTest extends TestCase
{
    /**
     * @var TestingIteratorAggregate
     */
    private $iterator = null;

    public function setUp()
    {
        parent::setUp();

        $this->iterator = new TestingIteratorAggregate();
    }

    public function testIteratorDefaultClass()
    {
        $this->assertEquals(\ArrayIterator::class, $this->iterator->getIteratorClass());
    }

    public function testCustomIteratorClass()
    {
        $this->iterator->setIteratorClass(CustomArrayIterator::class);

        $this->assertEquals(CustomArrayIterator::class, $this->iterator->getIteratorClass());
    }

    public function testIterator()
    {
        $this->iterator->setIteratorClass(CustomArrayIterator::class);

        $this->assertInstanceOf(CustomArrayIterator::class, $this->iterator->getIterator());
    }
}
