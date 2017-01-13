<?php

namespace Greg\Support\Tests;

use Greg\Support\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    /** @test */
    public function it_gets_sub_html()
    {
        $this->assertEquals(
            '<a>ipsum dolor sit amet.</a>',
            Html::sub('<a>Lorem ipsum dolor sit amet.</a>', 6)
        );
    }

    /** @test */
    public function it_cuts_tags()
    {
        $this->assertEquals(
            '<a>Lorem ipsum dolor  amet.</a>',
            Html::cutTag('<a>Lorem ipsum dolor <strong>sit</strong> amet.</a>', 'strong')
        );
    }
}
