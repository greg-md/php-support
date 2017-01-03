<?php

namespace Greg\Support\Tests;

use Greg\Support\Dir;
use Greg\Support\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /** @test */
    public function it_returns_file_extension()
    {
        $file = new File(__FILE__);

        $this->assertEquals('.php', $file->getExtension(true));

        $this->assertEquals('.php', File::extension(__FILE__, true));
    }

    /** @test */
    public function it_returns_file_name()
    {
        $file = new File(__FILE__);

        $this->assertEquals(__FILE__, $file->fileName());
    }

    /** @test */
    public function it_throws_an_exception_when_file_do_not_exists()
    {
        $this->expectException(\Exception::class);

        new File(__DIR__ . '/not_found.bla');
    }

    /** @test */
    public function it_checks_undefined_file()
    {
        $this->assertFalse(File::check(__DIR__ . '/not_found.bla', false));

        $this->assertFalse(File::isValid(__DIR__ . '/not_found.bla'));
    }

    /** @test */
    public function it_returns_file_mime()
    {
        $file = new File(__FILE__);

        $this->assertEquals('text/x-php', $file->getMime());

        $this->assertEquals('text/x-php', File::mime(__FILE__));
    }

    /** @test */
    public function it_makes_directory_of_the_file()
    {
        File::makeDir(__DIR__ . '/file_test/test.php');

        $this->assertDirectoryExists(__DIR__ . '/file_test');

        Dir::unlink(__DIR__ . '/file_test');

        $this->assertDirectoryNotExists(__DIR__ . '/file_test');
    }
}
