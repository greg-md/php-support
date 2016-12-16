<?php

namespace Greg\Support\Tests\Http;

use Greg\Support\Http\Request;
use Greg\Support\Http\RequestException;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    protected static $data = [
        'foo' => 'FOO',
        'bar' => 'BAR',
        'a'   => ['b' => 'c'],
    ];

    protected static $files = [
        'files' => [
            'name' => [
                'file1' => 'file1.png',
                'file2' => 'file2.png',
            ],
            'type' => [
                'file1' => 'image/png',
                'file2' => 'image/png',
            ],
            'size' => [
                'file1' => '1024',
                'file2' => '2048',
            ],
            'tmp_name' => [
                'file1' => '/tmp/upload_file1',
                'file2' => '/tmp/upload_file2',
            ],
            'error' => [
                'file1' => 0,
                'file2' => 0,
            ],
        ],
        'file3' => [
            'name'     => 'file3.png',
            'type'     => 'image/png',
            'size'     => '4096',
            'tmp_name' => '/tmp/upload_file3',
            'error'    => 0,
        ],
    ];

    protected static $humanFiles = [
        'files' => [
            'file1' => [
                'name'     => 'file1.png',
                'type'     => 'image/png',
                'size'     => '1024',
                'tmp_name' => '/tmp/upload_file1',
                'error'    => 0,
            ],
            'file2' => [
                'name'     => 'file2.png',
                'type'     => 'image/png',
                'size'     => '2048',
                'tmp_name' => '/tmp/upload_file2',
                'error'    => 0,
            ],
        ],
        'file3' => [
            'name'     => 'file3.png',
            'type'     => 'image/png',
            'size'     => '4096',
            'tmp_name' => '/tmp/upload_file3',
            'error'    => 0,
        ],
    ];

    public function setUp()
    {
        parent::setUp();

        $_GET = $_POST = $_REQUEST = static::$data;

        $_FILES = static::$files;

        $_SERVER['SERVER_PROTOCOL'] = 'http';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['SERVER_ADMIN'] = 'greg';
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $_SERVER['SERVER_PORT'] = 80;
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['REQUEST_URI'] = '/admin/?foo=bar';

        $_SERVER['SCRIPT_NAME'] = '/admin/index.php';

        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = null;
        $_SERVER['HTTP_IF_NONE_MATCH'] = null;
        $_SERVER['HTTP_REFERER'] = null;
    }

    /**
     * @param $type
     * @param $key
     *
     * @dataProvider serverDataProvider
     */
    public function testServerData($type, $key)
    {
        $this->assertEquals($_SERVER[$key], call_user_func_array([Request::class, $type], []));
    }

    public function serverDataProvider()
    {
        return [
            ['protocol', 'SERVER_PROTOCOL'],
            ['clientHost', 'HTTP_HOST'],
            ['serverHost', 'SERVER_NAME'],
            ['serverAdmin', 'SERVER_ADMIN'],
            ['secured', 'HTTPS'],
            ['with', 'HTTP_X_REQUESTED_WITH'],
            ['port', 'SERVER_PORT'],
            ['agent', 'HTTP_USER_AGENT'],
            ['ip', 'REMOTE_ADDR'],
            ['uri', 'REQUEST_URI'],
            ['referrer', 'HTTP_REFERER'],
            ['modifiedSince', 'HTTP_IF_MODIFIED_SINCE'],
            ['match', 'HTTP_IF_NONE_MATCH'],
            ['time', 'REQUEST_TIME'],
            ['microTime', 'REQUEST_TIME_FLOAT'],
        ];
    }

    public function testIsSecured()
    {
        $this->assertTrue(Request::isSecured());
    }

    public function testBaseUri()
    {
        $this->assertEquals('/admin', Request::baseUri());
    }

    public function testUriPath()
    {
        $this->assertEquals('/admin/', Request::uriPath());
    }

    public function testUriQuery()
    {
        $this->assertEquals('foo=bar', Request::uriQuery());
    }

    public function testRelativeUri()
    {
        $this->assertEquals('/?foo=bar', Request::relativeUri());
    }

    public function testRelativeUriPath()
    {
        $this->assertEquals('/', Request::relativeUriPath());
    }

    public function testAjax()
    {
        $this->assertTrue(Request::isAjax());
    }

    public function testHeader()
    {
        $this->assertEquals('Mozilla', Request::header('USER_AGENT'));
    }

    public function testHumanReadableFiles()
    {
        Request::humanReadableFiles();

        $this->assertEquals(static::$humanFiles, $_FILES);
    }

    /**
     * @depends testHumanReadableFiles
     */
    public function testGetFile()
    {
        $this->expectException(RequestException::class);

        Request::humanReadableFiles();

        Request::file('file3');
    }

    /**
     * @depends testHumanReadableFiles
     */
    public function testGetIndexFile()
    {
        $this->expectException(RequestException::class);

        Request::humanReadableFiles();

        Request::fileIndex('files.file1');
    }
}
