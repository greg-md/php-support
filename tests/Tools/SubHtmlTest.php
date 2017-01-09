<?php

namespace Greg\Support\Tests\Tools;

use Greg\Support\Tools\SubHtml;
use PHPUnit\Framework\TestCase;

class SubHtmlTest extends TestCase
{
    /** @test */
    public function it_gets_an_sub_html()
    {
        $subHtml = new SubHtml(6);

        $this->assertEquals(
            '<a>ipsum dolor sit amet.</a>',
            $subHtml->parse('<a>Lorem ipsum dolor sit amet.</a>')
        );
    }
}
