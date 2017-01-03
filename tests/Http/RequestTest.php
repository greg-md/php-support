<?php

namespace Greg\Support\Tests\Http;

use Greg\Support\Http\Request;
use Greg\Support\Http\RequestException;
use PHPUnit\Framework\TestCase;

class TestingRequest extends Request
{
    public static $isHumanReadableFiles = false;

    public static $checkFileUpload = false;

    public static $DS = DIRECTORY_SEPARATOR;
}

class RequestTest extends TestCase
{
    protected $data = [
        'foo' => 'FOO',
        'bar' => 'BAR',
        'a'   => ['b' => 'c'],
    ];

    protected $files = [
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
        'files4' => [
            'name' => [
                'files4' => [
                    'files4' => 'files4.png',
                ],
            ],
            'type' => [
                'files4' => [
                    'files4' => 'image/png',
                ],
            ],
            'size' => [
                'files4' => [
                    'files4' => '1024',
                ],
            ],
            'tmp_name' => [
                'files4' => [
                    'files4' => '/tmp/upload_files4',
                ],
            ],
            'error' => [
                'files4' => [
                    'files4' => 0,
                ],
            ],
        ],
    ];

    protected $humanFiles = [
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
        'files4' => [
            'files4' => [
                'files4' => [
                    'name'     => 'files4.png',
                    'type'     => 'image/png',
                    'size'     => '1024',
                    'tmp_name' => '/tmp/upload_files4',
                    'error'    => 0,
                ],
            ],
        ],
    ];

    private $request = null;

    public function setUp()
    {
        parent::setUp();

        $_GET = $_POST = $_REQUEST = $this->data;

        $_FILES = $this->files;

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
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->request = new Request([
            'foo' => 'required',
        ]);

        TestingRequest::$isHumanReadableFiles = false;

        TestingRequest::$checkFileUpload = false;
    }

    public function testInvalid()
    {
        $this->expectException(RequestException::class);

        new Request([
            'undefined' => 'required',
        ]);
    }

    public function testInvalidErrors()
    {
        try {
            new Request([
                'undefined' => 'required',
            ]);
        } catch (RequestException $e) {
            $this->assertArrayHasKey('undefined', $e->getInputErrors());
        }
    }

    /**
     * @param $type
     * @param $key
     *
     * @dataProvider serverDataProvider
     */
    public function testServerData($type, $key)
    {
        $this->assertEquals($_SERVER[$key], call_user_func_array([TestingRequest::class, $type], []));
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
            ['method', 'REQUEST_METHOD'],
        ];
    }

    public function testIsSecured()
    {
        $this->assertTrue(TestingRequest::isSecured());
    }

    public function testBaseUri()
    {
        $this->assertEquals('/admin', TestingRequest::baseUri());

        $_SERVER['SCRIPT_NAME'] = './';

        $this->assertEquals('', TestingRequest::baseUri());

        TestingRequest::$DS = '\\';

        $_SERVER['SCRIPT_NAME'] = '.\\';

        $this->assertEquals('', TestingRequest::baseUri());
    }

    public function testUriPath()
    {
        $this->assertEquals('/admin/', TestingRequest::uriPath());
    }

    public function testUriQuery()
    {
        $this->assertEquals('foo=bar', TestingRequest::uriQuery());
    }

    public function testRelativeUri()
    {
        $this->assertEquals('/?foo=bar', TestingRequest::relativeUri());
    }

    public function testRelativeUriPath()
    {
        $this->assertEquals('/', TestingRequest::relativeUriPath());
    }

    public function testAjax()
    {
        $this->assertTrue(TestingRequest::isAjax());
    }

    public function testHeader()
    {
        $this->assertEquals('Mozilla', TestingRequest::header('USER_AGENT'));
    }

    public function testHumanException()
    {
        $this->expectException(RequestException::class);

        $this->expectExceptionMessage('You cannot use indexes for $_FILES if `humanReadableFiles` method is not enabled.');

        TestingRequest::hasIndexFile('files.file1');
    }

    public function testHas()
    {
        $this->assertTrue(TestingRequest::has('foo'));

        $this->assertTrue(TestingRequest::hasGet('foo'));

        $this->assertTrue(TestingRequest::hasPost('foo'));

        $this->assertTrue(TestingRequest::hasFile('files'));
    }

    public function testHasIndex()
    {
        $this->assertTrue(TestingRequest::hasIndex('a.b'));

        $this->assertTrue(TestingRequest::hasIndexGet('a.b'));

        $this->assertTrue(TestingRequest::hasIndexPost('a.b'));

        TestingRequest::humanReadableFiles();

        $this->assertTrue(TestingRequest::hasIndexFile('files.file1'));
    }

    public function testParam()
    {
        $this->assertEquals($this->data['foo'], TestingRequest::param('foo'));

        $this->assertEquals($this->data['foo'], TestingRequest::get('foo'));

        $this->assertEquals($this->data['foo'], TestingRequest::post('foo'));

        $this->assertEquals($this->files['file3'], TestingRequest::file('file3'));
    }

    public function testParamArray()
    {
        $this->assertEquals([$this->data['foo']], TestingRequest::paramArray('foo'));

        $this->assertEquals([$this->data['foo']], TestingRequest::getArray('foo'));

        $this->assertEquals([$this->data['foo']], TestingRequest::postArray('foo'));

        $this->assertEquals([
            'name'     => [$this->files['file3']['name']],
            'type'     => [$this->files['file3']['type']],
            'size'     => [$this->files['file3']['size']],
            'tmp_name' => [$this->files['file3']['tmp_name']],
            'error'    => [$this->files['file3']['error']],
        ], TestingRequest::fileArray('file3'));

        TestingRequest::humanReadableFiles();

        $this->assertEquals([$this->humanFiles['file3']], TestingRequest::fileArray('file3'));
    }

    public function testParamIndex()
    {
        $this->assertEquals($this->data['a']['b'], TestingRequest::paramIndex('a.b'));

        $this->assertEquals($this->data['a']['b'], TestingRequest::getIndex('a.b'));

        $this->assertEquals($this->data['a']['b'], TestingRequest::postIndex('a.b'));

        TestingRequest::humanReadableFiles();

        $this->assertEquals($this->humanFiles['files']['file1'], TestingRequest::fileIndex('files.file1'));

        $this->assertEquals([
            'files' => [
                'file1' => $this->humanFiles['files']['file1'],
                'file2' => $this->humanFiles['files']['file2'],
            ]
        ], TestingRequest::fileIndex(['files.file1', 'files.file2']));
    }

    public function testFileIndexNoHumanReadable()
    {
        $this->expectException(RequestException::class);

        $this->expectExceptionMessage('You cannot use indexes for $_FILES if `humanReadableFiles` is disabled.');

        TestingRequest::fileIndex('files.file1');
    }

    public function testFileIndexArrayNoHumanReadable()
    {
        $this->expectException(RequestException::class);

        $this->expectExceptionMessage('You cannot use indexes for $_FILES if `humanReadableFiles` is disabled.');

        TestingRequest::fileIndexArray('files.file1');
    }

    public function testParamIndexArray()
    {
        $this->assertEquals([$this->data['a']['b']], TestingRequest::paramIndexArray('a.b'));

        $this->assertEquals([$this->data['a']['b']], TestingRequest::getIndexArray('a.b'));

        $this->assertEquals([$this->data['a']['b']], TestingRequest::postIndexArray('a.b'));

        TestingRequest::humanReadableFiles();

        $this->assertEquals([$this->humanFiles['files']['file1']], TestingRequest::fileIndexArray('files.file1'));
    }

    public function testFileMulti()
    {
        $this->assertArrayHasKey('file3', TestingRequest::file(['file3']));
    }

    public function testAllFiles()
    {
        $this->assertEquals($this->files, TestingRequest::file());

        TestingRequest::humanReadableFiles();

        $this->assertEquals($this->humanFiles, TestingRequest::file());
    }

    public function testFileUploadError()
    {
        $_FILES = [
            'invalid' => [
                'name'     => 'invalid.png',
                'type'     => 'plain/text',
                'size'     => '4096',
                'tmp_name' => '/tmp/upload_invalid',
                'error'    => UPLOAD_ERR_NO_FILE,
            ],
        ];

        $this->expectException(RequestException::class);

        $this->expectExceptionMessage('File upload error: ' . TestingRequest::UPLOAD_ERROR[UPLOAD_ERR_NO_FILE]);

        TestingRequest::file('invalid');
    }

    public function testFileUploadAttack()
    {
        TestingRequest::$checkFileUpload = true;

        $this->expectException(RequestException::class);

        $this->expectExceptionMessage('Possible file upload attack.');

        TestingRequest::file('file3');
    }

    public function testWrongFileMime()
    {
        $_FILES = [
            'invalid' => [
                'name'     => 'invalid.png',
                'type'     => 'plain/text',
                'size'     => '4096',
                'tmp_name' => '/tmp/upload_invalid',
                'error'    => 0,
            ],
        ];

        $this->expectException(RequestException::class);

        $this->expectExceptionMessage('Wrong file type was uploaded. Valid types are: image/png.');

        TestingRequest::file('invalid', 'image/png');
    }

    protected function fileUploadException()
    {
        $this->expectException(RequestException::class);

        $this->expectExceptionMessage('Possible file upload attack.');
    }
}
