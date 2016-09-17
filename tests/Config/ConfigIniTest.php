<?php

namespace Greg\Support\Tests\Config;

use Greg\Support\Config\ConfigException;
use Greg\Support\Config\ConfigIni;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigIniTest.
 *
 * @coversDefaultClass Greg\Support\Config\ConfigIni
 *
 * @covers ::parseFile
 * @covers ::parseString
 * @covers ::fetchContents
 * @covers ::fetchIndexes
 */
class ConfigIniTest extends TestCase
{
    public function dataProvider()
    {
        $test = ['foo' => 'f', 'bar' => ['a' => 1, 2]];

        return [
            [null, ['test' => $test]],
            ['test', $test],
        ];
    }

    /**
     * @param $section
     * @param $expected
     *
     * @dataProvider dataProvider
     * @covers ::file
     */
    public function testFile($section, $expected)
    {
        $this->assertEquals($expected, ConfigIni::file(__DIR__ . '/config.ini', $section));
    }

    /**
     * @param $section
     * @param $expected
     *
     * @dataProvider dataProvider
     * @covers ::string
     */
    public function testString($section, $expected)
    {
        $this->assertEquals($expected, ConfigIni::string(file_get_contents(__DIR__ . '/config.ini'), $section));
    }

    /**
     * @covers ::file
     */
    public function testException()
    {
        $this->expectException(ConfigException::class);

        ConfigIni::file(__DIR__ . '/config.ini', 'undevined section');
    }
}
