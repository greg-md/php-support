<?php

namespace Greg\Support\Tests\Config;

use Greg\Support\Config\ConfigDir;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigDirTest.
 *
 * @coversDefaultClass Greg\Support\Config\ConfigDir
 *
 * @covers \Greg\Support\Config\___gregRequireFile
 */
class ConfigDirTest extends TestCase
{
    /**
     * @covers ::path
     */
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
}
