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
}
