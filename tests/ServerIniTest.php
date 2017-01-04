<?php

namespace Greg\Support\Tests;

use Greg\Support\ServerIni;
use PHPUnit\Framework\TestCase;

class ServerIniTest extends TestCase
{
    /** @test */
    public function it_gets_all()
    {
        $this->assertArrayHasKey('error_reporting', ServerIni::getAll());
    }

    /** @test */
    public function it_gets_error_reporting()
    {
        $this->assertEquals(error_reporting(), ServerIni::get('error_reporting'));
    }

    /** @test */
    public function it_throws_an_exception_when_get_wrong_value()
    {
        $this->expectException(\Exception::class);

        ServerIni::get('some_wrong_value');
    }

    /** @test */
    public function it_throws_an_exception_when_set_wrong_value()
    {
        $this->expectException(\Exception::class);

        ServerIni::set('some_wrong_value', true);
    }

    /** @test */
    public function it_sets_values()
    {
        ServerIni::set('memory_limit', '1024M');

        $this->assertEquals('1024M', ini_get('memory_limit'));
    }
}
