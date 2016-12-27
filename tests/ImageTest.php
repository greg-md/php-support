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
        $this->assertEquals(IMAGETYPE_PNG, Image::getType($this->fileName));
    }

    /** @test */
    public function it_gets_image_size()
    {
        $this->assertCount(2, Image::getSize($this->fileName));
    }

    /** @test */
    public function it_gets_image_resource()
    {
        $this->assertTrue(is_resource(Image::getResource($this->fileName)));
    }

    /** @test */
    public function it_gets_image_sizes()
    {
        $this->assertEquals(493, Image::getWidth($this->fileName));

        $this->assertEquals(493, Image::getHeight($this->fileName));
    }

    /** @test */
    public function it_saves_into_jpeg()
    {
        $path = __DIR__ . '/testing.jpg';

        $this->assertFileExists($path, Image::saveJPEGFile(imagecreatefrompng($this->fileName), $path));

        unlink($path);
    }

    /** @test */
    public function it_saves_into_gif()
    {
        $path = __DIR__ . '/testing.gif';

        $this->assertFileExists($path, Image::saveGIFFile(imagecreatefrompng($this->fileName), $path));

        unlink($path);
    }

    /** @test */
    public function it_saves_into_png()
    {
        $path = __DIR__ . '/testing.png';

        $this->assertFileExists($path, Image::savePNGFile(imagecreatefrompng($this->fileName), $path));

        unlink($path);
    }
}
