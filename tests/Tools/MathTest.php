<?php

namespace Greg\Support\Tests\Tools;

use Greg\Support\Tools\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    /** @test */
    public function it_checks_canonical_division()
    {
        $this->assertEquals(1, Math::canonicalDivision(1));

        $this->assertEquals(1, Math::canonicalDivision('1/1'));

        $this->assertEquals(0, Math::canonicalDivision('1/0'));

        $this->assertEquals('2/3', Math::canonicalDivision('34/51'));
    }
}
