<?php

namespace Greg\Support\Tests\Accessor;

use Greg\Support\Accessor\ArrayObject;
use PHPUnit\Framework\TestCase;

class ArrayObjectTest extends TestCase
{
    /**
     * @var ArrayObject
     */
    protected $arrayObject = null;

    public function setUp()
    {
        parent::setUp();

        $this->arrayObject = new ArrayObject();
    }

    public function testNew()
    {
        $this->assertEquals([], $this->arrayObject->toArray());
    }

    public function testExchange()
    {
        $this->arrayObject->exchange(1);

        $this->assertEquals([1], $this->arrayObject->toArray());
    }

    public function testExchangeRef()
    {
        $new = [1];

        $this->arrayObject->exchangeRef($new);

        $new[] = 2;

        $this->assertEquals([1, 2], $this->arrayObject->toArray());
    }

    public function testAppend()
    {
        $this->arrayObject->append(1, 2, 3);

        $this->assertEquals([1, 2, 3], $this->arrayObject->toArray());
    }

    public function testAppendRef()
    {
        $a = 1;
        $b = 2;
        $c = 3;

        $this->arrayObject->appendRef($a, $b, $c);

        $c = 4;

        $this->assertEquals([1, 2, $c], $this->arrayObject->toArray());
    }

    public function testAppendKey()
    {
        $this->arrayObject->appendKey(null, 1);

        $this->arrayObject->appendKey('b', 2);

        $this->assertEquals([0 => 1, 'b' => 2], $this->arrayObject->toArray());
    }

    public function testAppendKeyRef()
    {
        $a = 1;

        $this->arrayObject->appendKeyRef('a', $a);

        $a = 2;

        $this->assertEquals(['a' => $a], $this->arrayObject->toArray());
    }

    public function testPrependKey()
    {
        $this->arrayObject->prependKey(null, 1);

        $this->arrayObject->prependKey('b', 2);

        $this->assertEquals(['b' => 2, 0 => 1], $this->arrayObject->toArray());
    }

    public function testPrependKeyRef()
    {
        $a = 1;

        $b = 2;

        $this->arrayObject->prependKeyRef('a', $a);

        $this->arrayObject->prependKeyRef('b', $b);

        $a = 3;

        $this->assertEquals(['b' => 2, 'a' => $a], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testAsort()
    {
        $this->arrayObject->exchange(['a', 'b']);

        $this->arrayObject->asort();

        $this->assertEquals([1 => 'b', 0 => 'a'], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testKsort()
    {
        $this->arrayObject->exchange([2 => 'b', 1 => 'a']);

        $this->arrayObject->ksort();

        $this->assertEquals([1 => 'a', 2 => 'b'], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testNatcasesort()
    {
        $this->arrayObject->exchange(['IMG0.png', 'img12.png', 'img10.png', 'img2.png', 'img1.png', 'IMG3.png']);

        $this->arrayObject->ksort();

        $this->assertEquals(
            [0 => 'IMG0.png', 4 => 'img1.png', 3 => 'img2.png', 5 => 'IMG3.png', 2 => 'img10.png', 1 => 'img12.png'],
            $this->arrayObject->toArray()
        );
    }

    /**
     * @depends testExchange
     */
    public function testNatsort()
    {
        $this->arrayObject->exchange(['img12.png', 'img10.png', 'img2.png', 'img1.png']);

        $this->arrayObject->ksort();

        $this->assertEquals(
            [3 => 'img1.png', 2 => 'img2.png', 1 => 'img10.png', 0 => 'img12.png'],
            $this->arrayObject->toArray()
        );
    }

    /**
     * @depends testExchange
     */
    public function testUasort()
    {
        $this->arrayObject->exchange(['a' => 4, 'b' => 8, 'c' => -1, 'd' => -9, 'e' => 2, 'f' => 5, 'g' => 3, 'h' => -4]);

        $this->arrayObject->uasort(function ($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        });

        $this->assertEquals(
            ['d' => -9, 'h' => -4, 'c' => -1, 'e' => 2, 'g' => 3, 'a' => 4, 'f' => 5, 'b' => 8],
            $this->arrayObject->toArray()
        );
    }

    /**
     * @depends testExchange
     */
    public function testUksort()
    {
        $this->arrayObject->exchange(['John' => 1, 'the Earth' => 2, 'an apple' => 3, 'a banana' => 4]);

        $this->arrayObject->uksort(function ($a, $b) {
            $a = preg_replace('@^(a|an|the) @', '', $a);

            $b = preg_replace('@^(a|an|the) @', '', $b);

            return strcasecmp($a, $b);
        });

        $this->assertEquals(
            ['an apple' => 3, 'a banana' => 4, 'the Earth' => 2, 'John' => 1],
            $this->arrayObject->toArray()
        );
    }

    /**
     * @depends testExchange
     */
    public function testCurrent()
    {
        $this->arrayObject->exchange(['step one', 'step two', 'step three', 'step four']);

        $this->assertEquals('step one', $this->arrayObject->current());

        return $this->arrayObject;
    }

    /**
     * @depends testCurrent
     *
     * @param ArrayObject $arrayObject
     * @return ArrayObject
     */
    public function testKey(ArrayObject $arrayObject)
    {
        $arrayObject->exchange(['step one', 'step two', 'step three', 'step four']);

        $this->assertEquals(0, $arrayObject->key());

        return $arrayObject;
    }

    /**
     * @depends testKey
     *
     * @param ArrayObject $arrayObject
     * @return ArrayObject
     */
    public function testNext(ArrayObject $arrayObject)
    {
        $arrayObject->next();

        $this->assertEquals(1, $arrayObject->key());

        return $arrayObject;
    }

    /**
     * @depends testNext
     *
     * @param ArrayObject $arrayObject
     */
    public function testReset(ArrayObject $arrayObject)
    {
        $arrayObject->reset();

        $this->assertEquals(0, $arrayObject->key());

        return $arrayObject;
    }

    /**
     * @depends testReset
     *
     * @param ArrayObject $arrayObject
     * @return ArrayObject
     */
    public function testFirst(ArrayObject $arrayObject)
    {
        $arrayObject->next();

        $arrayObject->next();

        $this->assertEquals('step one', $arrayObject->first());

        return $arrayObject;
    }

    /**
     * @depends testReset
     *
     * @param ArrayObject $arrayObject
     * @return ArrayObject
     */
    public function testLast(ArrayObject $arrayObject)
    {
        $this->assertEquals('step four', $arrayObject->last());

        return $arrayObject;
    }

    /**
     * @depends testExchange
     */
    public function testInArray()
    {
        $this->arrayObject->exchange([1, 2]);

        $this->assertTrue($this->arrayObject->inArray(1));

        $this->assertFalse($this->arrayObject->inArray('2', true));
    }

    /**
     * @depends testExchange
     */
    public function testInArrayValues()
    {
        $this->arrayObject->exchange([1, 2]);

        $this->assertTrue($this->arrayObject->inArrayValues([1, 2]));

        $this->assertFalse($this->arrayObject->inArray([1, '2'], true));
    }

    /*
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

        $object->mapRecursive(function ($value) {
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
    */
}
