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
}
