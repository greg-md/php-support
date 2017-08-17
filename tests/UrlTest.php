<?php

namespace Greg\Support\Tests;

use Greg\Support\Http\Request;
use Greg\Support\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    protected function setUp()
    {
        Request::mockHttpMode();
    }

    protected function tearDown()
    {
        Request::restoreHttpMode();
    }

    /** @test */
    public function it_checks_if_has_schema()
    {
        $this->assertTrue(Url::hasSchema('http://localhost'));
    }

    /** @test */
    public function it_gets_with_no_schema()
    {
        $this->assertEquals('localhost', Url::noSchema('http://localhost'));
    }

    /** @test */
    public function it_gets_with_schema()
    {
        $this->assertEquals('http://localhost', Url::schema('localhost'));
    }

    /** @test */
    public function it_gets_secured()
    {
        $this->assertEquals('https://localhost', Url::secured('localhost'));
    }

    /** @test */
    public function it_gets_unsecured()
    {
        $this->assertEquals('http://localhost', Url::unsecured('localhost'));
    }

    /** @test */
    public function it_gets_with_short_schema()
    {
        $this->assertEquals('//localhost', Url::shorted('localhost'));
    }

    /** @test */
    public function it_gets_absolute_url()
    {
        $this->assertEquals('http://localhost/foo', Url::absolute('/foo'));
    }

    /** @test */
    public function it_gets_relative_url()
    {
        $this->assertEquals('/foo', Url::relative('localhost/foo'));
    }

    /** @test */
    public function it_gets_server_relative_url()
    {
        $this->assertEquals('/foo', Url::serverRelative('localhost/foo'));

        $this->assertEquals('localhost2/foo', Url::serverRelative('localhost2/foo'));
    }

    /** @test */
    public function it_gets_host()
    {
        $this->assertEquals('localhost', Url::host('http://localhost/foo'));

        $this->assertEquals('localhost', Url::host('http://www.localhost/foo'));
    }

    /** @test */
    public function it_gets_host_level()
    {
        $this->assertEquals('mobile.example.com', Url::hostLevel('http://ultra.mobile.example.com/foo', 3));

        $this->assertEquals('example.com', Url::hostLevel('http://www.example.com/foo'));
    }

    /** @test */
    public function it_has_equals_host()
    {
        $this->assertTrue(Url::hostEquals('v1.example.com', 'v2.example.com'));
    }

    /** @test */
    public function it_gets_root_url()
    {
        $this->assertEquals('http://example.com', Url::root('http://example.com/foo/bar'));

        $this->assertEquals('example.com', Url::root('example.com/foo/bar'));
    }

    /** @test */
    public function it_removes_query_string()
    {
        $this->assertEquals('localhost/foo', Url::path('localhost/foo?bar=1'));
    }

    /** @test */
    public function it_gets_base_url()
    {
        $this->assertEquals(Url::base('/path'), '/path');

        $this->assertEquals(Url::base('/path', true), 'http://localhost/path');
    }

    /** @test */
    public function it_adds_query()
    {
        $this->assertEquals('/path?foo=1&bar=2', Url::addQuery('/path?foo=1', 'bar=2'));

        $this->assertEquals('/path?foo=1&bar=2', Url::addQuery('/path?foo=1', ['bar' => 2]));
    }

    /** @test */
    public function it_init_an_url()
    {
        $this->assertTrue(is_resource(Url::init('localhost', true)));
    }

    /** @test */
    public function it_gets_effective_url()
    {
        $this->assertEquals('http://example.com/', Url::effective('http://example.com/'));
    }

    /** @test */
    public function it_gets_contents()
    {
        $this->assertRegExp('#Example Domain#i', Url::contents('http://example.com'));
    }
}
