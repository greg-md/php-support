<?php

namespace Greg\Support\Tests\Http;

use Greg\Support\Http\Request;
use Greg\Support\Http\Response;
use Greg\Support\Http\ResponseException;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class ResponseTest extends TestCase
{
    /**
     * @var Response
     */
    protected $response = null;

    protected $data = null;

    public function setUp()
    {
        parent::setUp();

        $this->response = new Response();

        ob_start();
    }

    public function tearDown()
    {
        $this->assertEquals(md5($this->data), md5(ob_get_clean()));
    }

    public function testConstructor()
    {
        $response = new Response('foo', 'text/html');

        $this->sendAndCheck('foo', $response);

        $this->assertEquals('text/html', $response->getContentType());
    }

    public function testBack()
    {
        $_SERVER['HTTP_REFERER'] = '/foo';

        $this->response->back();

        $this->sendAndCheck();

        $this->assertEquals(Request::referrer(), $this->response->getLocation());
    }

    public function testDownload()
    {
        $this->response->download('foo', 'bar.txt', 'text/plain');

        $this->sendAndCheck('foo');

        $this->assertEquals('bar.txt', $this->response->getFileName());

        $this->assertEquals('text/plain', $this->response->getContentType());

        $this->assertEquals('download', $this->response->getDisposition());
    }

    public function testInline()
    {
        $this->response->inline('foo', 'bar.txt', 'text/plain');

        $this->sendAndCheck('foo');

        $this->assertEquals('bar.txt', $this->response->getFileName());

        $this->assertEquals('text/plain', $this->response->getContentType());

        $this->assertEquals('inline', $this->response->getDisposition());
    }

    public function testJson()
    {
        $this->response->json($data = ['foo' => 'bar']);

        $this->sendAndCheck(json_encode($data));

        $this->assertEquals('application/json', $this->response->getContentType());
    }

    public function testRefresh()
    {
        $this->response->refresh();

        $this->sendAndCheck();

        $this->assertEquals(Request::uri(), $this->response->getLocation());
    }

    public function testIsHtml()
    {
        $this->sendAndCheck();

        $this->assertTrue($this->response->isHtml());
    }

    public function testCharset()
    {
        $this->response->setCharset('UTF-16');

        $this->sendAndCheck();

        $this->assertEquals('UTF-16', $this->response->getCharset());
    }

    public function testCode()
    {
        $this->response->setCode('404');

        $this->sendAndCheck();

        $this->assertEquals('404', $this->response->getCode());
    }

    public function testToString()
    {
        $this->response->setContent('foo');

        $this->assertEquals('foo', $this->response->toString());

        $this->assertEquals('foo', (string) $this->response);
    }

    public function testSendLocation()
    {
        $this->sendAndCheckTrue(Response::sendLocation('', 200));
    }

    public function testSendRefresh()
    {
        $this->sendAndCheckTrue(Response::sendRefresh());
    }

    public function testSendBack()
    {
        $this->sendAndCheckTrue(Response::sendBack());
    }

    public function testSendJson()
    {
        $this->sendAndCheckTrue(Response::sendJson('foo'), '"foo"');
    }

    public function testSendHtml()
    {
        $this->sendAndCheckTrue(Response::sendHtml($html = '<p>Hello World!</p>'), $html);
    }

    public function testSendImage()
    {
        $this->sendAndCheckTrue(Response::sendImage(__DIR__ . '/image.png'), file_get_contents(__DIR__ . '/image.png'));
    }

    public function testSendWrongImage()
    {
        $this->expectException(ResponseException::class);

        $this->expectExceptionMessage('File is not an image.');

        Response::sendImage(__DIR__ . '/image.txt');
    }

    public function testSendText()
    {
        $this->sendAndCheckTrue(Response::sendText('foo'), 'foo');
    }

    public function testSendJpeg()
    {
        ob_start();

        imagejpeg(imagecreatefromjpeg(__DIR__ . '/image.jpg'), null, 100);

        $file = ob_get_clean();

        $this->sendAndCheckTrue(Response::sendJpeg(imagecreatefromjpeg(__DIR__ . '/image.jpg'), 100), $file);
    }

    public function testSendGif()
    {
        ob_start();

        imagegif(imagecreatefromgif(__DIR__ . '/image.gif'));

        $file = ob_get_clean();

        $this->sendAndCheckTrue(Response::sendGif(imagecreatefromgif(__DIR__ . '/image.gif')), $file);
    }

    public function testSendPng()
    {
        ob_start();

        imagepng(imagecreatefrompng(__DIR__ . '/image.png'));

        $file = ob_get_clean();

        $this->sendAndCheckTrue(Response::sendPng(imagecreatefrompng(__DIR__ . '/image.png')), $file);
    }

    public function testFlushContent()
    {
        $this->sendAndCheckTrue(Response::flush());
    }

    public function testIsModifiedSince()
    {
        $lastModified = substr(date('r', time() - 30), 0, -5) . 'GMT';

        $eTag = '"' . md5($lastModified) . '"';

        $this->sendAndCheckTrue(!Response::isModifiedSince(time()));

        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = $lastModified;

        $_SERVER['HTTP_IF_NONE_MATCH'] = $eTag;

        $this->sendAndCheckTrue(!Response::isModifiedSince(time(), 60));

        $this->sendAndCheckTrue(Response::isModifiedSince(time() - 30, 60));

        $_SERVER['HTTP_IF_NONE_MATCH'] = 'wrong';

        $this->sendAndCheckTrue(!Response::isModifiedSince(time(), 60));
    }

    private function sendAndCheck($data = '', Response $response = null)
    {
        ($response ?: $this->response)->send();

        $this->data = $data;
    }

    private function sendAndCheckTrue($response, $data = '')
    {
        $this->assertTrue($response);

        $this->data = $data;
    }
}
