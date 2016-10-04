<?php

namespace Greg\Support\Tests\Http;

use Greg\Support\Arr;
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

    public static function setUpBeforeClass()
    {
        $_GET = static::$data;

        $_POST = static::$data;

        $_REQUEST = static::$data;

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
    }

    protected function newInstance()
    {
        return new Request(static::$data);
    }

    public function testHasParams()
    {
        $request = $this->newInstance();

        $this->assertTrue($request->hasParams());
    }

    public function testGetAll()
    {
        $request = $this->newInstance();

        $this->assertEquals(static::$data, $request->getAll());
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testHasTypeParams($type)
    {
        $request = $this->newInstance();

        $this->assertTrue($request->{'has' . $type . 'Params'}());
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testGetAllType($type)
    {
        $request = $this->newInstance();

        $this->assertEquals(static::$data, $request->{'getAll' . $type}());
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testHasType($type)
    {
        $request = $this->newInstance();

        $this->assertTrue($request->{'has' . $type}('foo'));
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testHasIndexType($type)
    {
        $request = $this->newInstance();

        $this->assertTrue($request->{'hasIndex' . $type}('a.b'));
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testGetType($type)
    {
        $request = $this->newInstance();

        $this->assertEquals('FOO', $request->{'get' . $type}('foo'));
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testGetArrayType($type)
    {
        $request = $this->newInstance();

        $this->assertEquals(['FOO'], $request->{'getArray' . $type}('foo'));
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testGetIndexType($type)
    {
        $request = $this->newInstance();

        $this->assertEquals('c', $request->{'getIndex' . $type}('a.b'));
    }

    /**
     * @param $type
     *
     * @dataProvider typesProvider
     */
    public function testGetIndexArrayType($type)
    {
        $request = $this->newInstance();

        $this->assertEquals(['c'], $request->{'getIndexArray' . $type}('a.b'));
    }

    public function typesProvider()
    {
        return [
            [''],
            ['Get'],
            ['Post'],
            ['Request'],
        ];
    }

    /**
     * @param $type
     * @param $key
     *
     * @dataProvider serverDataProvider
     */
    public function testServerData($type, $key)
    {
        $this->assertEquals(Arr::get($_SERVER, $key), call_user_func_array([Request::class, $type], []));
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

        Request::getFile('file3');
    }

    /**
     * @depends testHumanReadableFiles
     */
    public function testGetIndexFile()
    {
        $this->expectException(RequestException::class);

        Request::humanReadableFiles();

        Request::getIndexFile('files.file1');
    }
}
