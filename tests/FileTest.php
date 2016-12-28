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
    public function it_returns_file_mime()
    {
        $file = new File(__FILE__);

        $this->assertEquals('text/x-php', $file->getMime());

        $this->assertEquals('text/x-php', File::mime(__FILE__));
    }

    /** @test */
    public function it_makes_directory_of_the_file()
    {
        File::makeDir(__DIR__ . '/test/test.php');

        $this->assertDirectoryExists(__DIR__ . '/test');

        Dir::unlink(__DIR__ . '/test');

        $this->assertDirectoryNotExists(__DIR__ . '/test');
    }
}
