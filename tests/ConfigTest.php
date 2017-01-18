<?php

namespace Greg\Support\Tests\Config;

use Greg\Support\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private $config = [
        'foo'     => 'f',
        'bar.a'   => 1,
        'bar.'    => 2,
        'bar.b.c' => 3,
    ];

    private $configIndex = [
        'foo' => 'f',
        'bar' => [
            'a' => 1,
            2,
            'b' => [
                'c' => 3,
            ],
        ],
    ];

    public function testFile()
    {
        $this->assertEquals($this->config, Config::iniFile(__DIR__ . '/config.ini'));
    }

    public function testFileIndex()
    {
        $this->assertEquals($this->configIndex, Config::iniFile(__DIR__ . '/config.ini', null, '.'));
    }

    public function testNoSectionException()
    {
        $this->expectException(\Exception::class);

        Config::iniFile(__DIR__ . '/config.ini', 'test');
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
        $this->assertEquals($expected, Config::iniFile(__DIR__ . '/config.section.ini', $section, '.'));
    }

    /**
     * @param $section
     * @param $expected
     *
     * @dataProvider dataProvider
     */
    public function testSectionString($section, $expected)
    {
        $this->assertEquals($expected, Config::iniString(file_get_contents(__DIR__ . '/config.section.ini'), $section, '.'));
    }

    public function testSectionException()
    {
        $this->expectException(\Exception::class);

        Config::iniFile(__DIR__ . '/config.section.ini', 'undefined section');
    }
    
    public function testParse()
    {
        $config = Config::dir(__DIR__ . '/config');

        $this->assertEquals([
            'c1' => [
                'c2' => [
                    'a' => 1,
                    'b' => 2,
                ],
            ],
            'c3' => [
                'c' => 3,
                'd' => 4,
            ],
        ], $config);
    }

    public function testParseMain()
    {
        $config = Config::dir(__DIR__ . '/config', 'c3');

        $this->assertEquals([
            'c'  => 3,
            'd'  => 4,
            'c1' => [
                'c2' => [
                    'a' => 1,
                    'b' => 2,
                ],
            ],
        ], $config);
    }

    public function testException()
    {
        $this->expectException(\Exception::class);

        Config::dir(__DIR__ . '/config', 'c4');
    }
}
