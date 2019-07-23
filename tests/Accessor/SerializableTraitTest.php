<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\SerializableTrait;
use PHPUnit\Framework\TestCase;

class TestingSerializable
{
    public $accessor = [];

    use SerializableTrait;

    private function &getAccessor()
    {
        return $this->accessor;
    }

    private function setAccessor(array $accessor)
    {
        return $this->accessor = $accessor;
    }
}

class SerializableTraitTest extends TestCase
{
    /**
     * @var TestingSerializable
     */
    private $serializable = null;

    protected function setUp(): void
    {
        $this->serializable = new TestingSerializable();
    }

    public function testUnserialize()
    {
        $this->serializable->accessor = [1, 2, 3];

        $this->assertEquals('a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}', $this->serializable->serialize());
    }

    public function testSerialize()
    {
        $this->serializable->unserialize('a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}');

        $this->assertEquals([1, 2, 3], $this->serializable->accessor);
    }
}
