<?php

namespace Greg\Support\Tests\Config;

use Greg\Support\Config\FileConfigIni;
use PHPUnit\Framework\TestCase;

class FileConfigInitTest extends TestCase
{
    /**
     * @covers FileConfigIni::parse
     */
    public function testParse()
    {
        $config = FileConfigIni::parse(__DIR__.'/config.ini');

        $this->assertEquals([
            'test' => [
                'foo' => 'bar',
            ],
        ], $config);
    }
}
