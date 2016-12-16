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
     *
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
     *
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
     *
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
     *
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

        $this->assertFalse($this->arrayObject->inArrayValues([1, '2'], true));
    }

    public function testMerge()
    {
        $this->arrayObject->merge([1, 2]);

        $this->arrayObject->merge([3, 4]);

        $this->assertEquals([1, 2, 3, 4], $this->arrayObject->toArray());
    }

    public function testMergeRecursive()
    {
        $this->arrayObject->mergeRecursive([1, 2, 'a' => [3]]);

        $this->arrayObject->mergeRecursive([5, 'a' => [4]]);

        $this->assertEquals([1, 2, 'a' => [3, 4], 5], $this->arrayObject->toArray());
    }

    public function testMergePrepend()
    {
        $this->arrayObject->mergePrepend([1, 2]);

        $this->arrayObject->mergePrepend([3, 4]);

        $this->assertEquals([3, 4, 1, 2], $this->arrayObject->toArray());
    }

    public function testMergePrependRecursive()
    {
        $this->arrayObject->mergePrependRecursive([1, 2, 'a' => [3]]);

        $this->arrayObject->mergePrependRecursive([5, 'a' => [4]]);

        $this->assertEquals([5, 'a' => [4, 3], 1, 2], $this->arrayObject->toArray());
    }

    /**
     * @depends testMerge
     */
    public function testMergeValues()
    {
        $this->arrayObject->merge(['a' => [1, 2]]);
        $this->arrayObject->merge(['b' => [3, 4]]);

        $this->arrayObject->mergeValues();

        $this->assertEquals([1, 2, 3, 4], $this->arrayObject->toArray());
    }

    public function testReplace()
    {
        $this->arrayObject->replace([1, 2]);

        $this->arrayObject->replace([3, 4]);

        $this->assertEquals([3, 4], $this->arrayObject->toArray());
    }

    public function testReplaceRecursive()
    {
        $this->arrayObject->replaceRecursive([1, 2, 'a' => [3]]);

        $this->arrayObject->replaceRecursive([5, 'a' => [4]]);

        $this->assertEquals([5, 2, 'a' => [4]], $this->arrayObject->toArray());
    }

    public function testReplacePrepend()
    {
        $this->arrayObject->replacePrepend([1, 2]);

        $this->arrayObject->replacePrepend([3, 4]);

        $this->assertEquals([1, 2], $this->arrayObject->toArray());
    }

    public function testReplacePrependRecursive()
    {
        $this->arrayObject->replacePrependRecursive([1, 2, 'a' => [3]]);

        $this->arrayObject->replacePrependRecursive([5, 'a' => [4]]);

        $this->assertEquals([1, 'a' => [3], 2], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testReplaceValues()
    {
        $this->arrayObject->exchange(['a' => [1, 2], 'b' => [3, 4]]);

        $this->arrayObject->replaceValues();

        $this->assertEquals([3, 4], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testDiff()
    {
        $this->arrayObject->exchange([1, 2, 3]);

        $this->arrayObject->diff([2, 3, 4]);

        $this->assertEquals([1], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testMap()
    {
        $this->arrayObject->exchange([1, 2, 3]);

        $this->arrayObject->map(function($n) {
            return pow($n, 2);
        });

        $this->assertEquals([1, 4, 9], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testMapRecursive()
    {
        $this->arrayObject->exchange([1, [2, 3]]);

        $this->arrayObject->mapRecursive(function($n) {
            return pow($n, 2);
        });

        $this->assertEquals([1, [4, 9]], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testFilter()
    {
        $this->arrayObject->exchange([1, 2, null, 0, 3, '']);

        $this->arrayObject->filter();

        $this->assertEquals([0 => 1, 1 => 2, 4 => 3], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testFilterRecursive()
    {
        $this->arrayObject->exchange([1, 2, null, [0, 3, '']]);

        $this->arrayObject->filterRecursive();

        $this->assertEquals([0 => 1, 1 => 2, 3 => [1 => 3]], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testReverse()
    {
        $this->arrayObject->exchange([1, 2, 3]);

        $this->arrayObject->reverse();

        $this->assertEquals([3, 2, 1], $this->arrayObject->toArray());

        $this->arrayObject->reverse(true);

        $this->assertEquals([2 => 1, 1 => 2, 0 => 3], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testChunk()
    {
        $this->arrayObject->exchange([1, 2, 3]);

        $this->arrayObject->chunk(1);

        $this->assertEquals([[1], [2], [3]], $this->arrayObject->toArray());
    }

    /**
     * @depends testExchange
     */
    public function testImplode()
    {
        $this->arrayObject->exchange([1, 2, 3]);

        $this->assertEquals('1,2,3', $this->arrayObject->implode(','));
    }

    /*
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
