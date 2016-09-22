<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\ArrayObject;
use PHPUnit\Framework\TestCase;

class ArrayObjectTest extends TestCase
{
    protected function newObject()
    {
        return new ArrayObject(['a']);
    }

    public function testNew()
    {
        $object = $this->newObject();

        $this->assertEquals(['a'], $object->toArray());
    }

    public function testExchange()
    {
        $object = $this->newObject();

        $new = ['a', 'b' => 'c'];

        $object->exchange($new);

        $this->assertEquals($new, $object->toArray());

        return $object;
    }

    public function testExchangeRef()
    {
        $object = $this->newObject();

        $new = ['a', 'b' => 'c'];

        $object->exchangeRef($new);

        $new[] = 'e';

        $this->assertEquals($new, $object->toArray());

        return $object;
    }

    public function testAppend()
    {
        $object = $this->newObject();

        $object->append('b');

        $this->assertEquals(['a', 'b'], $object->toArray());

        return $object;
    }

    public function testAppendRef()
    {
        $object = $this->newObject();

        $ref = 'b';

        $object->appendRef($ref);

        $ref = 'c';

        $this->assertEquals(['a', 'c'], $object->toArray());

        return $object;
    }

    public function testAppendKey()
    {
        $object = $this->newObject();

        $object->appendKey('b', 'c');

        $this->assertEquals(['a', 'b' => 'c'], $object->toArray());

        return $object;
    }

    public function testAppendKeyRef()
    {
        $object = $this->newObject();

        $ref = 'c';

        $object->appendKeyRef('b', $ref);

        $ref = 'd';

        $this->assertEquals(['a', 'b' => 'd'], $object->toArray());

        return $object;
    }

    public function testPrepend()
    {
        $object = $this->newObject();

        $object->prepend('-b');

        $this->assertEquals(['-b', 'a'], $object->toArray());

        return $object;
    }

    public function testPrependRef()
    {
        $object = $this->newObject();

        $ref = '-b';

        $object->prependRef($ref);

        $ref = '-c';

        $this->assertEquals(['-c', 'a'], $object->toArray());

        return $object;
    }

    public function testPrependKey()
    {
        $object = $this->newObject();

        $object->prependKey('-b', '-c');

        $this->assertEquals(['-b' => '-c', 'a'], $object->toArray());

        return $object;
    }

    public function testPrependKeyRef()
    {
        $object = $this->newObject();

        $ref = '-c';

        $object->prependKeyRef('-b', $ref);

        $ref = '-d';

        $this->assertEquals(['-b' => '-d', 'a'], $object->toArray());

        return $object;
    }

    public function testInArrayValues()
    {
        $object = $this->newObject();

        $object->append('b');

        $this->assertTrue($object->inArrayValues(['a', 'b']));

        return $object;
    }

    public function testNotInArrayValues()
    {
        $object = $this->newObject();

        $this->assertNotTrue($object->inArrayValues(['a', 'b']));

        return $object;
    }

    public function testMergePrepend()
    {
        $object = $this->newObject();

        $object->mergePrepend(['-b'], ['-c']);

        $this->assertEquals(['-c', '-b', 'a'], $object->toArray());

        return $object;
    }

    public function testMergePrependRecursive()
    {
        $object = $this->newObject();

        $object->merge(['b' => ['b1', 'b2']]);

        $object->mergePrependRecursive(['b' => ['-b2']]);

        $this->assertEquals(['b' => ['-b2', 'b1', 'b2'], 'a'], $object->toArray());

        return $object;
    }

    public function testReplacePrepend()
    {
        $object = $this->newObject();

        $object->replacePrepend(['-b'], ['-c']);

        $this->assertEquals(['a'], $object->toArray());

        return $object;
    }

    public function testMapRecursive()
    {
        $object = $this->newObject();

        $object->exchange([1, [2, 3]]);

        $object->mapRecursive(function($value) {
            return pow($value, 2);
        });

        $this->assertEquals([1, [4, 9]], $object->toArray());

        return $object;
    }

    public function testFilterRecursive()
    {
        $object = $this->newObject();

        $object->append(['b', '', 'c']);

        $object->filterRecursive();

        $this->assertEquals(['a', [0 => 'b', 2 => 'c']], $object->toArray());

        return $object;
    }

    public function testGroup()
    {
        $object = $this->newObject();

        $object->exchange([
            [
                'a' => '1',
                'b' => '2',
            ],
            [
                'a' => '3',
                'b' => '4',
            ],
        ]);

        $object->group('a', true, true);

        $this->assertEquals([
            1 => [
                'b' => '2',
            ],
            3 => [
                'b' => '4',
            ],
        ], $object->toArray());

        return $object;
    }
}
