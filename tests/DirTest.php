<?php

namespace Greg\Support\Tests;

use Greg\Support\Dir;
use PHPUnit\Framework\TestCase;

class DirTest extends TestCase
{
    /** @test */
    public function create_test_directory()
    {
        Dir::make(__DIR__ . '/test/test', true);

        $this->assertDirectoryExists(__DIR__ . '/test/test');
    }

    /**
     * @test
     *
     * @depends create_test_directory
     */
    public function copy_test_directory()
    {
        file_put_contents(__DIR__ . '/test/test/file.txt', 'Test');

        symlink(__DIR__ . '/test/test/file.txt', __DIR__ . '/test/test/file_link.txt');

        Dir::copy(__DIR__ . '/test/test', __DIR__ . '/test/test_copy');

        $this->assertDirectoryExists(__DIR__ . '/test/test_copy');
    }

    /**
     * @test
     *
     * @depends copy_test_directory
     */
    public function unlink_test_directory()
    {
        Dir::unlink(__DIR__ . '/test');

        $this->assertDirectoryNotExists(__DIR__ . '/test');
    }
}
