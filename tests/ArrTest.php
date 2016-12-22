<?php

namespace Greg\Support\Tests;

use Greg\Support\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    public function testHas()
    {
        $accessor = [
            'a' => 1,
            'b' => 2,
        ];

        $this->assertTrue(Arr::has($accessor, 'a'));

        $this->assertTrue(Arr::has($accessor, ['a', 'b']));

        $this->assertFalse(Arr::has($accessor, ['undefined']));
    }

    public function testHasIndex()
    {
        $accessor = [
            'a' => 1,
            'b' => 2,
            'c' => [
                'd' => 4,
            ],
            'e' => [
                'f' => 4,
            ],
        ];

        $this->assertTrue(Arr::hasIndex($accessor, 'c.d'));

        $this->assertTrue(Arr::hasIndex($accessor, ['b', 'c.d']));

        $this->assertFalse(Arr::hasIndex($accessor, ['e.g']));
    }

    public function testSet()
    {
        $accessor = [];

        $this->assertArrayHasKey('foo', Arr::set($accessor, 'foo', 'bar'));

        $this->assertArrayHasKey(0, Arr::set($accessor, null, 'null'));
    }

    public function testSetRef()
    {
        $accessor = [];

        $value = 'bar';

        Arr::setRef($accessor, 'foo', $value);

        $value = 'bar2';

        $this->assertTrue(in_array($value, $accessor));
    }

    public function testSetRefNoKey()
    {
        $accessor = [];

        $value = 'bar';

        Arr::setRef($accessor, null, $value);

        $value = 'bar2';

        $this->assertTrue(in_array($value, $accessor));

        $this->assertArrayHasKey(0, $accessor);
    }

    public function testSetIndex()
    {
        $accessor = [];

        $this->assertArrayHasKey('b', Arr::setIndex($accessor, 'a.b', 'ab')['a']);

        $this->assertArrayHasKey(0, Arr::setIndex($accessor, 'a.', 'null')['a']);

        $this->assertArrayHasKey('c', Arr::setIndex($accessor, 'c', 3));
    }

    public function testSetIndexRef()
    {
        $accessor = [];

        $value = 'ab';

        Arr::setIndexRef($accessor, 'a.b', $value);

        $value = 'ab2';

        $this->assertTrue(in_array($value, $accessor['a']));

        $c = 3;

        Arr::setIndexRef($accessor, 'c', $c);

        $c = 33;

        $this->assertTrue(in_array($c, $accessor));
    }

    /** @test */
    public function get_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $this->assertEquals(['a' => 1, 'B' => 2, 'not' => 'null'], Arr::get($accessor, ['a', 'B' => 'b', 'not'], ['a' => 11, 'not' => 'null']));
    }

    /** @test */
    public function get_ref_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $else = ['a' => 11, 'not' => 'else'];

        $reference = &Arr::getRef($accessor, ['a', 'B' => 'b', 'not'], $else);

        $reference['not'] = 'notify';

        $reference['B'] = 22;

        $this->assertEquals(['a' => 1, 'b' => 22], $accessor);

        $this->assertEquals(['a' => 11, 'not' => 'notify'], $else);
    }

    /** @test */
    public function get_force_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $this->assertEquals(['a' => 1, 'B' => 2, 'not' => 'else'], Arr::getForce($accessor, ['a', 'B' => 'b', 'not'], ['not' => 'else']));

        $this->assertArrayHasKey('not', $accessor);
    }

    /** @test */
    public function get_force_reference_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $else = ['a' => 11, 'not' => 'else'];

        $references = Arr::getForceRef($accessor, ['a', 'B' => 'b', 'not'], $else);

        $references['not'] = 'notify';

        $references['B'] = 22;

        $this->assertEquals(['a' => 1, 'b' => 22, 'not' => 'notify'], $accessor);

        $this->assertEquals(['a' => 11, 'not' => 'notify'], $else);
    }

    /** @test */
    public function get_array_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $this->assertEquals(['a' => [1], 'B' => [2], 'not' => ['null']], Arr::getArray($accessor, ['a', 'B' => 'b', 'not'], ['a' => 11, 'not' => 'null']));
    }

    /** @test */
    public function get_array_ref_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $else = ['a' => 11, 'not' => 'else'];

        $reference = &Arr::getArrayRef($accessor, ['a', 'B' => 'b', 'not'], $else);

        $reference['not'] = ['notify'];

        $reference['B'] = [22];

        $this->assertEquals(['a' => [1], 'b' => [22]], $accessor);

        $this->assertEquals(['a' => 11, 'not' => ['notify']], $else);
    }

    /** @test */
    public function get_array_force_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $this->assertEquals(['a' => [1], 'B' => [2], 'not' => ['else']], Arr::getArrayForce($accessor, ['a', 'B' => 'b', 'not'], ['a' => 11, 'not' => 'else']));

        $this->assertArrayHasKey('not', $accessor);
    }

    /** @test */
    public function get_array_force_reference_by_key()
    {
        $accessor = ['a' => 1, 'b' => 2];

        $else = ['a' => 11, 'not' => 'else'];

        $references = Arr::getArrayForceRef($accessor, ['a', 'B' => 'b', 'not'], $else);

        $references['not'] = ['notify'];

        $references['B'] = [22];

        $this->assertEquals(['a' => [1], 'b' => [22], 'not' => ['notify']], $accessor);

        $this->assertEquals(['a' => 11, 'not' => ['notify']], $else);
    }

    /** @test */
    public function get_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $this->assertEquals(
            ['a' => ['a' => 1], 'B' => 2, 'c' => 3, 'not' => ['not' => 'null']],
            Arr::getIndex($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], ['a' => ['a' => 11], 'not' => ['not' => 'null']])
        );
    }

    /** @test */
    public function get_ref_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $else = ['a' => ['a' => 11], 'not' => ['not' => 'else']];

        $reference = &Arr::getIndexRef($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], $else);

        $reference['not']['not'] = 'notify';

        $reference['B'] = 22;

        $this->assertEquals(['a' => ['a' => 1], 'b' => ['b' => 22], 'c' => 3], $accessor);

        $this->assertEquals(['a' => ['a' => 11], 'not' => ['not' => 'notify']], $else);
    }

    /** @test */
    public function get_force_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $this->assertEquals(
            ['a' => ['a' => 1], 'B' => 2, 'c' => 3, 'not' => ['not' => 'else']],
            Arr::getIndexForce($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], ['not' => ['not' => 'else']])
        );

        $this->assertArrayHasKey('not', $accessor);
    }

    /** @test */
    public function get_force_reference_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $else = ['a' => ['a' => 11], 'not' => ['not' => 'else']];

        $references = Arr::getIndexForceRef($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], $else);

        $references['not']['not'] = 'notify';

        $references['B'] = 22;

        $this->assertEquals(['a' => ['a' => 1], 'b' => ['b' => 22], 'c' => 3, 'not' => ['not' => 'notify']], $accessor);

        $this->assertEquals(['a' => ['a' => 11], 'not' => ['not' => 'notify']], $else);
    }

    /** @test */
    public function get_array_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $this->assertEquals(
            ['a' => ['a' => [1]], 'B' => [2], 'c' => [3], 'not' => ['not' => ['null']]],
            Arr::getIndexArray($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], ['a' => ['a' => 11], 'not' => ['not' => 'null']])
        );
    }

    /** @test */
    public function get_array_ref_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $else = ['a' => ['a' => 11], 'not' => ['not' => 'else']];

        $reference = &Arr::getIndexArrayRef($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], $else);

        $reference['not']['not'] = ['notify'];

        $reference['B'] = [22];

        $this->assertEquals(['a' => ['a' => [1]], 'b' => ['b' => [22]], 'c' => [3]], $accessor);

        $this->assertEquals(['a' => ['a' => 11], 'not' => ['not' => ['notify']]], $else);
    }

    /** @test */
    public function get_array_force_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $this->assertEquals(
            ['a' => ['a' => [1]], 'B' => [2], 'c' => [3], 'not' => ['not' => ['else']]],
            Arr::getIndexArrayForce($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], ['a' => ['a' => 11], 'not' => ['not' => 'else']])
        );

        $this->assertArrayHasKey('not', $accessor);
    }

    /** @test */
    public function get_array_force_reference_by_index()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $else = ['a' => ['a' => 11], 'not' => ['not' => 'else']];

        $references = Arr::getIndexArrayForceRef($accessor, ['a.a', 'B' => 'b.b', 'c', 'not.not'], $else);

        $references['not']['not'] = ['notify'];

        $references['B'] = [22];

        $this->assertEquals(['a' => ['a' => [1]], 'b' => ['b' => [22]], 'c' => [3], 'not' => ['not' => ['notify']]], $accessor);

        $this->assertEquals(['a' => ['a' => 11], 'not' => ['not' => ['notify']]], $else);
    }

    public function testDel()
    {
        $accessor = ['a' => 1, 'b' => 2, 'c' => 3];

        $this->assertEquals(['c' => 3], Arr::del($accessor, ['a', 'b']));
    }

    public function testDelIndex()
    {
        $accessor = ['a' => ['a' => 1], 'b' => ['b' => 2], 'c' => 3];

        $this->assertEquals(['a' => [], 'c' => 3], Arr::delIndex($accessor, ['a.a', 'b.b.0', 'b', 'e.e']));
    }

    public function testSuffix()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals(['1km', '2km', '3km'], Arr::suffix($accessor, 'km'));
    }

    public function testPrefix()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals(['the 1', 'the 2', 'the 3'], Arr::prefix($accessor, 'the '));
    }

    public function testAppend()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals([1, 2, 3, 4], Arr::append($accessor, 4));
    }

    public function testAppendRef()
    {
        $accessor = [1, 2, 3];

        $a = 4;

        $b = 5;

        Arr::appendRef($accessor, $a, $b);

        $a = 5;

        $this->assertEquals([1, 2, 3, $a, $b], $accessor);
    }

    public function testAppendKey()
    {
        $accessor = [1, 2, 3];

        Arr::appendKey($accessor, 4, 4);

        Arr::appendKey($accessor, null, 5);

        $this->assertEquals([1, 2, 3, 4 => 4, 5], $accessor);
    }

    public function testAppendKeyRef()
    {
        $accessor = [1, 2, 3];

        $a = 4;

        Arr::appendKeyRef($accessor, 4, $a);

        $a = 5;

        $b = 5;

        Arr::appendKeyRef($accessor, null, $b);

        $this->assertEquals([1, 2, 3, 4 => $a, 5], $accessor);
    }

    public function testAppendIndex()
    {
        $accessor = [];

        Arr::appendIndex($accessor, 'a.b', 'c');

        $this->assertEquals(['a' => ['b' => 'c']], $accessor);
    }

    public function testAppendIndexRef()
    {
        $accessor = [];

        $c = 'c';

        Arr::appendIndexRef($accessor, 'a.b', $c);

        $c = 'cc';

        $this->assertEquals(['a' => ['b' => $c]], $accessor);
    }

    public function testPrepend()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals([4, 1, 2, 3], Arr::prepend($accessor, 4));
    }

    public function testPrependRef()
    {
        $accessor = [1, 2, 3];

        $a = 4;

        $b = 5;

        Arr::prependRef($accessor, $a, $b);

        $a = 5;

        $this->assertEquals([$a, $b, 1, 2, 3], $accessor);
    }

    public function testPrependKey()
    {
        $accessor = [1, 2, 3];

        Arr::prependKey($accessor, 'four', 4);

        Arr::prependKey($accessor, null, 5);

        $this->assertEquals([5, 'four' => 4, 1, 2, 3], $accessor);
    }

    public function testPrependKeyRef()
    {
        $accessor = [1, 2, 3];

        $a = 4;

        Arr::prependKeyRef($accessor, 'four', $a);

        $a = 5;

        $b = 5;

        Arr::prependKeyRef($accessor, null, $b);

        $this->assertEquals([5, 'four' => $a, 1, 2, 3], $accessor);
    }

    public function testPrependIndex()
    {
        $accessor = [1, 2, 3];

        Arr::prependIndex($accessor, 'a.b', 'c');

        $this->assertEquals(['a' => ['b' => 'c'], 1, 2, 3], $accessor);
    }

    public function testPrependIndexRef()
    {
        $accessor = [1, 2, 3];

        $c = 'c';

        Arr::prependIndexRef($accessor, 'a.b', $c);

        $c = 'cc';

        $this->assertEquals(['a' => ['b' => $c], 1, 2, 3], $accessor);
    }

    public function testFirst()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals(1, Arr::first($accessor));

        $this->assertEquals(2, Arr::first($accessor, function ($value) {
            return $value === 2;
        }));

        $this->assertEquals('else', Arr::first($accessor, function ($value) {
            return $value === -1;
        }, 'else'));
    }

    public function testLast()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals(3, Arr::last($accessor));

        $empty = [];

        $this->assertEquals('else', Arr::last($empty, null, 'else'));

        $this->assertEquals(2, Arr::last($accessor, function ($value) {
            return $value === 2;
        }));

        $this->assertEquals('else', Arr::last($accessor, function ($value) {
            return $value === -1;
        }, 'else'));
    }

    public function testMap()
    {
        $accessor = [1, 2, 3];

        $result = Arr::map($accessor, function ($n) {
            return pow($n, 2);
        });

        $this->assertEquals([1, 4, 9], $result);
    }

    public function testMapRecursive()
    {
        $accessor = [1, [2, 3]];

        $result = Arr::mapRecursive($accessor, function ($n) {
            return pow($n, 2);
        });

        $this->assertEquals([1, [4, 9]], $result);
    }

    public function testFilter()
    {
        $accessor = [1, 2, null, 0, 3, ''];

        $result = Arr::filter($accessor);

        $this->assertEquals([0 => 1, 1 => 2, 4 => 3], $result);
    }

    public function testFilterRecursive()
    {
        $accessor = [1, 2, null, [0, 3, '']];

        $result = Arr::filterRecursive($accessor);

        $this->assertEquals([0 => 1, 1 => 2, 3 => [1 => 3]], $result);
    }

    public function testGroup()
    {
        $accessor = [
            [
                'a' => '1',
                'b' => '2',
            ],
            [
                'a' => '3',
                'b' => '4',
            ],
        ];

        $this->assertEquals([
            1 => [
                'b' => '2',
            ],
            3 => [
                'b' => '4',
            ],
        ], Arr::group($accessor, 'a', true, true));

        $this->assertEquals([
            1 => [
                2 => [
                    'a' => '1',
                    'b' => '2',
                ],
            ],
            3 => [
                4 => [
                    'a' => '3',
                    'b' => '4',
                ],
            ],
        ], Arr::group($accessor, 2));
    }

    public function testInArrayValues()
    {
        $accessor = [1, 2, null, [0, 3, '']];

        $this->assertTrue(Arr::inArrayValues($accessor, [1, 2]));

        $this->assertFalse(Arr::inArrayValues($accessor, [1, 2, 'b']));
    }

    public function testPairs()
    {
        $accessor = [
            [
                'key'   => 'a',
                'value' => 1,
            ],
            [
                'key'   => 'b',
                'value' => 2,
            ],
        ];

        $this->assertEquals(['a' => 1, 'b' => 2], Arr::pairs($accessor, 'key', 'value'));
    }

    public function testIsFilled()
    {
        $accessor = [1, 2, 3];

        $this->assertTrue(Arr::isFilled($accessor));

        $accessor = [1, 2, 3, ''];

        $this->assertFalse(Arr::isFilled($accessor));
    }

    public function testEach()
    {
        $accessor = [1, 2, 3];

        $result = Arr::each($accessor, function ($n) {
            return pow($n, 2);
        });

        $this->assertEquals([1, 4, 9], $result);
    }

    public function testCount()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals(1, Arr::count($accessor, function ($value) {
            return $value === 1;
        }));
    }

    public function testPack()
    {
        $accessor = [1, 2, 3];

        $this->assertEquals(['0.1', '1.2', '2.3'], Arr::pack($accessor, '.'));
    }

    public function testFixIndexes()
    {
        $accessor = [
            'a'   => 1,
            'b.b' => 2,
            'c'   => [
                'c.c' => 3,
            ],
        ];

        $this->assertEquals([
            'a' => 1,
            'b' => [
                'b' => 2,
            ],
            'c' => [
                'c' => [
                    'c' => 3,
                ],
            ],
        ], Arr::fixIndexes($accessor));
    }

    public function testPackIndexes()
    {
        $accessor = [
            'a' => 1,
            'b' => [
                'b' => 2,
            ],
            'c' => [
                'c' => [
                    'c' => 3,
                ],
            ],
        ];

        $this->assertEquals([
            'a'     => 1,
            'b.b'   => 2,
            'c.c.c' => 3,
        ], Arr::packIndexes($accessor));
    }

    public function testPackIndexesRef()
    {
        $accessor = [
            'a' => 1,
            'b' => [
                'b' => 2,
            ],
            'c' => [
                'c' => [
                    'c' => 3,
                ],
            ],
        ];

        $packed = Arr::packIndexesRef($accessor);

        $accessor['a'] = 11;

        $this->assertEquals([
            'a'     => 11,
            'b.b'   => 2,
            'c.c.c' => 3,
        ], $packed);
    }

    public function testUnpackIndexes()
    {
        $accessor = [
            'a'     => 1,
            'b.b'   => 2,
            'c.c.c' => 3,
        ];

        $unpacked = Arr::unpackIndexesRef($accessor);

        $accessor['b.b'] = 22;

        $this->assertEquals([
            'a' => 1,
            'b' => [
                'b' => 22,
            ],
            'c' => [
                'c' => [
                    'c' => 3,
                ],
            ],
        ], $unpacked);
    }

    public function testArrayValuesRecursive()
    {
        $accessor = [
            'a' => 1,
            'b' => [
                'b' => 2,
            ],
            'c' => 3,
        ];

        $this->assertEquals([1, [2], 3], Arr::valuesRecursive($accessor));
    }
}
