<?php

namespace Greg\Support\Tests\Tools;

use Greg\Support\Tools\ColorGenerator;
use PHPUnit\Framework\TestCase;

class ColorGeneratorTest extends TestCase
{
    public function testGenerator()
    {
        $this->assertEquals('#32cc00', ColorGenerator::generate(40));
    }
}
