<?php

namespace Greg\Support\Tests;

use Greg\Support\ServerConfig;
use PHPUnit\Framework\TestCase;

class ServerConfigTest extends TestCase
{
    /** @test */
    public function it_manages_encoding()
    {
        $this->assertTrue(ServerConfig::encoding('UTF-8'));

        $this->assertEquals('UTF-8', ServerConfig::encoding());
    }

    /** @test */
    public function it_manages_timezone()
    {
        $this->assertTrue(ServerConfig::timezone('UTC'));

        $this->assertEquals('UTC', ServerConfig::timezone());
    }
}
