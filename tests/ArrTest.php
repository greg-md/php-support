<?php

namespace Greg\Support\Tests;

use Greg\Support\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    public function testHas()
    {
        $array = ['foo' => true];

        $this->assertTrue(Arr::has($array, 'foo'));
    }

    public function testHasIndex()
    {
        $array = ['foo' => ['bar' => true]];

        $this->assertTrue(Arr::hasIndex($array, 'foo.bar'));
    }

    public function testSet()
    {
        $array = ['foo' => true];

        $this->assertArrayHasKey('bar', Arr::set($array, 'bar', 'BAR'));
    }
}
