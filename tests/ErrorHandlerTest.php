<?php

namespace Greg\Support\Tests;

use Greg\Support\ErrorHandler;
use PHPUnit\Framework\TestCase;

class ErrorHandlerTest extends TestCase
{
    /** @test */
    public function it_throws_exception()
    {
        ErrorHandler::throwException();

        $this->expectException(\Exception::class);

        mkdir(__DIR__ . '/no/recursive/dir');
    }

    /** @test */
    public function it_disables_errors()
    {
        ErrorHandler::disable();

        mkdir(__DIR__ . '/no/recursive/dir');

        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @depends it_throws_exception
     *
     * @expectedException \PHPUnit_Framework_Error_Warning
     */
    public function it_restores_errors()
    {
        ErrorHandler::restore();

        mkdir(__DIR__ . '/no/recursive/dir');
    }
}
