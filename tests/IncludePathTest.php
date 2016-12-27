<?php

namespace Greg\Support\Tests;

use Greg\Support\IncludePath;
use PHPUnit\Framework\TestCase;

class IncludePathTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        set_include_path('.');
    }

    /** @test */
    public function it_appends_new_path()
    {
        IncludePath::append('/append/path');

        $this->assertEquals('.:/append/path', get_include_path());
    }

    /** @test */
    public function it_prepend_new_path()
    {
        IncludePath::prepend('/prepend/path');

        $this->assertEquals('/prepend/path:.', get_include_path());
    }

    /** @test */
    public function it_resets_included_paths()
    {
        set_include_path('.:/some/path');

        IncludePath::reset();

        $this->assertEquals('.', get_include_path());
    }

    /** @test */
    public function it_checks_if_file_exists_in_included_paths()
    {
        set_include_path('.:' . __DIR__);

        $this->assertTrue(IncludePath::exists('image.png'));
    }
}
