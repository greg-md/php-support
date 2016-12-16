<?php

namespace Greg\Support\Tests\Http;

use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    /**
     * @var Response
     */
    protected $response = null;

    public function setUp()
    {
        parent::setUp();

        $this->response = new Response();
    }

    public function testBack()
    {
        $this->response->back();

        $this->assertEquals(Request::referrer(), $this->response->getLocation());
    }

    public function testDownload()
    {
        $this->response->download('foo', 'bar.txt', 'text/plain');

        $this->assertEquals('foo', $this->response->getContent());

        $this->assertEquals('bar.txt', $this->response->getFileName());

        $this->assertEquals('text/plain', $this->response->getContentType());

        $this->assertEquals('download', $this->response->getDisposition());
    }

    public function testInline()
    {
        $this->response->inline('foo', 'bar.txt', 'text/plain');

        $this->assertEquals('foo', $this->response->getContent());

        $this->assertEquals('bar.txt', $this->response->getFileName());

        $this->assertEquals('text/plain', $this->response->getContentType());

        $this->assertEquals('inline', $this->response->getDisposition());
    }

    public function testJson()
    {
        $data = [
            'foo' => 'bar',
        ];

        $this->response->json($data);

        $this->assertEquals('application/json', $this->response->getContentType());

        $this->assertEquals(json_encode($data), $this->response->getContent());
    }

    public function testRefresh()
    {
        $this->response->refresh();

        $this->assertEquals(Request::uri(), $this->response->getLocation());
    }
}
