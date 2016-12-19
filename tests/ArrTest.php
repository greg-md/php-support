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

        $reference = &Arr::getIndexArrayRef($accessor, ['a.a', 'B' => 'b.b', 'not.not'], $else);

        $reference['not']['not'] = ['notify'];

        $reference['B'] = [22];

        $this->assertEquals(['a' => ['a' => [1]], 'b' => ['b' => [22]], 'c' => 3], $accessor);

        $this->assertEquals(['a' => ['a' => 11], 'not' => ['not' => ['notify']]], $else);
    }

//    /** @test */
//    public function get_array_force_by_key()
//    {
//        $accessor = ['a' => 1, 'b' => 2];
//
//        $this->assertEquals(['a' => [1], 'B' => [2], 'not' => ['else']], Arr::getArrayForce($accessor, ['a', 'B' => 'b', 'not'], ['a' => 11, 'not' => 'else']));
//
//        $this->assertArrayHasKey('not', $accessor);
//    }
//
//    /** @test */
//    public function get_array_force_reference_by_key()
//    {
//        $accessor = ['a' => 1, 'b' => 2];
//
//        $else = ['a' => 11, 'not' => 'else'];
//
//        $references = Arr::getArrayForceRef($accessor, ['a', 'B' => 'b', 'not'], $else);
//
//        $references['not'] = ['notify'];
//
//        $references['B'] = [22];
//
//        $this->assertEquals(['a' => [1], 'b' => [22], 'not' => ['notify']], $accessor);
//
//        $this->assertEquals(['a' => 11, 'not' => ['notify']], $else);
//    }
}
