<?php

namespace Greg\Support\Tests\Tools;

use Greg\Support\Tools\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function testGenerator()
    {
        $this->assertEquals('#32cc00', Color::generate(40));

        $this->assertEquals('#0000ff', Color::generate(101));
    }

    public function testHex2rgb()
    {
        $this->assertEquals([0, 0, 0], Color::hex2rgb('#000000'));
    }

    public function testRgb2hex()
    {
        $this->assertEquals('#000000', Color::rgb2hex([0, 0, 0]));
    }
}
