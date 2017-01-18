<?php

namespace Greg\Support\Tests;

use Greg\Support\Server;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    /** @test */
    public function it_gets_script_name()
    {
        $this->assertEquals($_SERVER['SCRIPT_NAME'], Server::scriptName());
    }

    /** @test */
    public function it_gets_script_file()
    {
        $this->assertEquals($_SERVER['SCRIPT_FILENAME'], Server::scriptFile());
    }

    /** @test */
    public function it_gets_request_time()
    {
        $this->assertEquals($_SERVER['REQUEST_TIME'], Server::requestTime());
    }

    /** @test */
    public function it_gets_request_micro_time()
    {
        $this->assertEquals($_SERVER['REQUEST_TIME_FLOAT'], Server::requestMicroTime());
    }

    /** @test */
    public function it_gets_document_root()
    {
        $this->assertEquals($_SERVER['DOCUMENT_ROOT'], Server::documentRoot());
    }

    /** @test */
    public function it_has_something()
    {
        $this->assertTrue(Server::has('DOCUMENT_ROOT'));
    }

    /** @test */
    public function it_gets_something()
    {
        $this->assertEquals($_SERVER['DOCUMENT_ROOT'], Server::get('DOCUMENT_ROOT'));
    }

    /** @test */
    public function it_manages_encoding()
    {
        $this->assertTrue(Server::encoding('UTF-8'));

        $this->assertEquals('UTF-8', Server::encoding());
    }

    /** @test */
    public function it_manages_timezone()
    {
        $this->assertTrue(Server::timezone('UTC'));

        $this->assertEquals('UTC', Server::timezone());
    }

    /** @test */
    public function it_gets_all()
    {
        $this->assertArrayHasKey('error_reporting', Server::iniAll());
    }

    /** @test */
    public function it_gets_error_reporting()
    {
        $this->assertEquals(error_reporting(), Server::iniGet('error_reporting'));
    }

    /** @test */
    public function it_throws_an_exception_when_get_wrong_value()
    {
        $this->expectException(\Exception::class);

        Server::iniGet('some_wrong_value');
    }

    /** @test */
    public function it_throws_an_exception_when_set_wrong_value()
    {
        $this->expectException(\Exception::class);

        Server::iniSet('some_wrong_value', true);
    }

    /** @test */
    public function it_sets_values()
    {
        Server::iniSet('memory_limit', '1024M');

        $this->assertEquals('1024M', ini_get('memory_limit'));
    }
}
