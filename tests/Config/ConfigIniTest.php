<?php

namespace Greg\Support\Tests\Config;

use Greg\Support\Config\ConfigException;
use Greg\Support\Config\ConfigIni;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigIniTest.
 *
 * @coversDefaultClass Greg\Support\Config\ConfigIni
 */
class ConfigIniTest extends TestCase
{
    private $config = [
        'foo' => 'f',
        'bar.a' => 1,
        'bar.' => 2,
        'bar.b.c' => 3
    ];

    private $configIndex = [
        'foo' => 'f',
        'bar' => [
            'a' => 1,
            2,
            'b' => [
                'c' => 3
            ]
        ]
    ];

    public function testFile()
    {
        $this->assertEquals($this->config, ConfigIni::file(__DIR__ . '/config.ini'));
    }

    public function testFileIndex()
    {
        $this->assertEquals($this->configIndex, ConfigIni::file(__DIR__ . '/config.ini', null, '.'));
    }

    public function testNoSectionException()
    {
        $this->expectException(ConfigException::class);

        ConfigIni::file(__DIR__ . '/config.ini', 'test');
    }

    public function dataProvider()
    {
        return [
            [null, ['test' => $this->configIndex]],
            ['test', $this->configIndex],
        ];
    }

    /**
     * @param $section
     * @param $expected
     *
     * @dataProvider dataProvider
     */
    public function testSectionFile($section, $expected)
    {
        $this->assertEquals($expected, ConfigIni::file(__DIR__ . '/config.section.ini', $section, '.'));
    }

    /**
     * @param $section
     * @param $expected
     *
     * @dataProvider dataProvider
     */
    public function testSectionString($section, $expected)
    {
        $this->assertEquals($expected, ConfigIni::string(file_get_contents(__DIR__ . '/config.section.ini'), $section, '.'));
    }

    public function testSectionException()
    {
        $this->expectException(ConfigException::class);

        ConfigIni::file(__DIR__ . '/config.section.ini', 'undefined section');
    }
}
