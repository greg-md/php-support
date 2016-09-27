<?php

namespace Greg\Support\Tests\Http;

use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    protected function newInstance()
    {
        return new Response();
    }

    public function testBack()
    {
        $request = $this->newInstance();

        $request->back();

        $this->assertEquals(Request::referrer(), $request->getLocation());
    }

    public function testDownload()
    {
        $request = $this->newInstance();

        $request->download('foo', 'bar.txt', 'text/plain');

        $this->assertEquals('foo', $request->getContent());
        $this->assertEquals('bar.txt', $request->getFileName());
        $this->assertEquals('text/plain', $request->getContentType());
        $this->assertEquals('download', $request->getDisposition());
    }

    public function testInline()
    {
        $request = $this->newInstance();

        $request->inline('foo', 'bar.txt', 'text/plain');

        $this->assertEquals('foo', $request->getContent());
        $this->assertEquals('bar.txt', $request->getFileName());
        $this->assertEquals('text/plain', $request->getContentType());
        $this->assertEquals('inline', $request->getDisposition());
    }

    public function testJson()
    {
        $request = $this->newInstance();

        $data = [
            'foo' => 'bar',
        ];

        $request->json($data);

        $this->assertEquals('application/json', $request->getContentType());
        $this->assertEquals(json_encode($data), $request->getContent());
    }

    public function testRefresh()
    {
        $request = $this->newInstance();

        $request->refresh();

        $this->assertEquals(Request::uri(), $request->getLocation());
    }
}