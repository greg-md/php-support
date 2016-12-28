<?php

namespace Greg\Support\Tests;

use Greg\Support\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    private $fileName = null;

    public function setUp()
    {
        parent::setUp();

        $this->fileName = __DIR__ . '/image.png';
    }

    /** @test */
    public function it_checks_image()
    {
        $this->assertTrue(Image::check($this->fileName, false));

        $this->assertFalse(Image::check(__FILE__, false));
    }

    /** @test */
    public function it_gets_image_type()
    {
        $this->assertEquals(IMAGETYPE_PNG, Image::type($this->fileName));
    }

    /** @test */
    public function it_gets_image_size()
    {
        $this->assertCount(2, Image::size($this->fileName));
    }

    /** @test */
    public function it_gets_image_resource()
    {
        $this->assertTrue(is_resource(Image::resource($this->fileName)));
    }

    /** @test */
    public function it_gets_image_sizes()
    {
        $this->assertEquals(493, Image::width($this->fileName));

        $this->assertEquals(493, Image::height($this->fileName));
    }
}
