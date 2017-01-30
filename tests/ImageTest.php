<?php

namespace Greg\Support\Tests;

use Greg\Support\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    private $fileName = null;

    /**
     * @var Image
     */
    private $image = null;

    public function setUp()
    {
        parent::setUp();

        $this->fileName = __DIR__ . '/image.png';

        $this->image = new Image($this->fileName);
    }

    /** @test */
    public function it_checks_image()
    {
        $this->assertTrue(Image::check($this->fileName, false));

        $this->assertFalse(Image::check(__FILE__, false));

        $this->assertFalse(Image::check(__DIR__ . '/not_image.bla', false));

        $this->expectException(\Exception::class);

        $this->expectExceptionMessage('File does not exists.');

        Image::check(__DIR__ . '/.gitignore');
    }

    /** @test */
    public function it_gets_image_type()
    {
        $this->assertEquals(IMAGETYPE_PNG, Image::type($this->fileName));

        $this->assertEquals(IMAGETYPE_PNG, $this->image->getType());

        $this->assertEquals(IMAGETYPE_JPEG, Image::type(__DIR__ . '/image.jpg'));

        $this->assertEquals(IMAGETYPE_GIF, Image::type(__DIR__ . '/image.gif'));
    }

    /** @test */
    public function it_gets_image_size()
    {
        $this->assertCount(2, Image::size($this->fileName));

        $this->assertCount(2, $this->image->getSize());
    }

    /** @test */
    public function it_gets_image_resource()
    {
        $this->assertTrue(is_resource(Image::resource($this->fileName)));

        $this->assertTrue(is_resource($this->image->getResource()));

        $this->assertTrue(is_resource(Image::resource(__DIR__ . '/image.jpg')));

        $this->assertTrue(is_resource(Image::resource(__DIR__ . '/image.gif')));
    }

    /** @test */
    public function it_gets_image_sizes()
    {
        $this->assertEquals(493, Image::width($this->fileName));

        $this->assertEquals(493, $this->image->getWidth());

        $this->assertEquals(493, Image::height($this->fileName));

        $this->assertEquals(493, $this->image->getHeight());
    }

    /** @test */
    public function it_gets_image_extension()
    {
        $this->assertEquals('png', Image::extension($this->fileName));

        $this->assertEquals('png', $this->image->getExtension());

        $this->assertEquals('jpg', Image::extension(__DIR__ . '/image.jpg'));

        $this->assertEquals('gif', Image::extension(__DIR__ . '/image.gif'));
    }

    /** @test */
    public function it_gets_image_mime()
    {
        $this->assertEquals('image/png', Image::mime($this->fileName));

        $this->assertEquals('image/png', $this->image->getMime());
    }
}
