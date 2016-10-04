<?php

namespace Greg\Support\Tests;

use Greg\Support\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    public function testHas()
    {
        $array = ['foo' => true];

        $this->assertTrue(Arr::hasRef($array, 'foo'));
    }

    public function testHasIndex()
    {
        $array = ['foo' => ['bar' => true]];

        $this->assertTrue(Arr::hasIndexRef($array, 'foo.bar'));
    }

    public function testSet()
    {
        $array = ['foo' => true];

        $this->assertArrayHasKey('bar', Arr::setRef($array, 'bar', 'BAR'));
    }
}
