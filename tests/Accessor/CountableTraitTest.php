<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\CountableTrait;
use PHPUnit\Framework\TestCase;

class TestingCountable
{
    public $accessor;

    use CountableTrait;

    public function &getAccessor()
    {
        return $this->accessor;
    }
}

class CountableTraitTest extends TestCase
{
    /**
     * @var TestingCountable
     */
    private $countable = null;

    protected function setUp(): void
    {
        $this->countable = new TestingCountable();
    }

    public function testCount()
    {
        $this->countable->accessor = [1, 2];

        $this->assertEquals(2, $this->countable->count());
    }
}
