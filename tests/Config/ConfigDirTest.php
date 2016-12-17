<?php

namespace Greg\Support\Tests\Config;

use Greg\Support\Config\ConfigDir;
use Greg\Support\Config\ConfigException;
use PHPUnit\Framework\TestCase;

class ConfigDirTest extends TestCase
{
    public function testParse()
    {
        $config = ConfigDir::path(__DIR__ . '/config');

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
        $config = ConfigDir::path(__DIR__ . '/config', 'c3');

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
        $this->expectException(ConfigException::class);

        ConfigDir::path(__DIR__ . '/config', 'c4');
    }
}
