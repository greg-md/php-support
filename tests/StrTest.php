<?php

namespace Greg\Support\Tests;

use Greg\Support\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    /** @test */
    public function it_transforms_to_camel_case()
    {
        $this->assertEquals('FooBar', Str::camelCase('Foo Bar'));
    }

    /** @test */
    public function it_transforms_to_lower_camel_case()
    {
        $this->assertEquals('fooBar', Str::lowerCamelCase('Foo Bar'));
    }

    /** @test */
    public function it_transforms_to_snake_case()
    {
        $this->assertEquals('Foo_Bar', Str::snakeCase('Foo Bar'));

        $this->assertEquals('Foo_Bar', Str::snakeCase('FooBar', true));
    }

    /** @test */
    public function it_transforms_to_lower_snake_case()
    {
        $this->assertEquals('foo_bar', Str::lowerSnakeCase('Foo Bar'));

        $this->assertEquals('foo_bar', Str::lowerSnakeCase('FooBar', true));
    }

    /** @test */
    public function it_transforms_to_upper_snake_case()
    {
        $this->assertEquals('FOO_BAR', Str::upperSnakeCase('Foo Bar'));

        $this->assertEquals('FOO_BAR', Str::upperSnakeCase('FooBar', true));
    }

    /** @test */
    public function it_transforms_to_upper_words_snake_case()
    {
        $this->assertEquals('Foo_Bar', Str::upperWordsSnakeCase('foo bar'));

        $this->assertEquals('Foo_Bar', Str::upperWordsSnakeCase('fooBar', true));
    }

    /** @test */
    public function it_transforms_to_kebab_case()
    {
        $this->assertEquals('Foo-Bar', Str::kebabCase('Foo Bar'));

        $this->assertEquals('Foo-Bar', Str::kebabCase('FooBar', true));
    }

    /** @test */
    public function it_transforms_to_spinal_case()
    {
        $this->assertEquals('foo-bar', Str::spinalCase('Foo Bar'));

        $this->assertEquals('foo-bar', Str::spinalCase('FooBar', true));
    }

    /** @test */
    public function it_transforms_to_train_case()
    {
        $this->assertEquals('Foo-Bar', Str::trainCase('foo bar'));

        $this->assertEquals('Foo-Bar', Str::trainCase('fooBar', true));
    }

    /** @test */
    public function it_transforms_to_lisp_case()
    {
        $this->assertEquals('Foo-bar', Str::lispCase('foo bar'));

        $this->assertEquals('Foo-bar', Str::lispCase('fooBar', true));
    }

    /** @test */
    public function it_transforms_to_php_snake_case()
    {
        $this->assertEquals('_1FooBar', Str::phpCamelCase('1Foo Bar'));

        $this->assertEquals('_1FooBar', Str::phpLowerCamelCase('1Foo Bar'));

        $this->assertEquals('_1Foo_Bar', Str::phpSnakeCase('1Foo Bar'));

        $this->assertEquals('_1_Foo_Bar', Str::phpSnakeCase('1FooBar', true));

        $this->assertEquals('_1foo_bar', Str::phpLowerSnakeCase('1Foo Bar'));

        $this->assertEquals('_1_foo_bar', Str::phpLowerSnakeCase('1FooBar', true));

        $this->assertEquals('_1FOO_BAR', Str::phpUpperSnakeCase('1Foo Bar'));

        $this->assertEquals('_1_FOO_BAR', Str::phpUpperSnakeCase('1FooBar', true));

        $this->assertEquals('_1foo_Bar', Str::phpUpperWordsSnakeCase('1foo bar'));

        $this->assertEquals('_1foo_Bar', Str::phpUpperWordsSnakeCase('1fooBar', true));
    }

    /** @test */
    public function it_transforms_to_abbreviation()
    {
        $this->assertEquals('FB', Str::abbreviation('Foo Bar'));
    }

    /** @test */
    public function it_replaces_the_accents()
    {
        $this->assertEquals('Inghetata', Str::replaceAccents('Înghețată'));
    }

    /** @test */
    public function it_checks_if_string_match_a_pattern()
    {
        $this->assertTrue(Str::is('Foo Bar', 'Foo Bar'));

        $this->assertTrue(Str::is('Foo Bar', 'Foo *'));
    }

    /** @test */
    public function it_starts_with()
    {
        $this->assertTrue(Str::startsWith('Foo Bar', 'Fo'));

        $this->assertTrue(Str::startsWith('Foo Bar', ['Foo', 'Foo B']));

        $this->assertFalse(Str::startsWith('Foo Bar', 'Fe'));
    }

    /** @test */
    public function it_ends_with()
    {
        $this->assertTrue(Str::endsWith('Foo Bar', 'ar'));

        $this->assertTrue(Str::endsWith('Foo Bar', ['ar', 'o Bar']));

        $this->assertFalse(Str::endsWith('Foo Bar', 'er'));
    }

    /** @test */
    public function it_shifts()
    {
        $this->assertEquals('Bar', Str::shift('Foo Bar', 'Foo '));
    }

    /** @test */
    public function it_quotes()
    {
        $this->assertEquals('"Foo Bar"', Str::quote('Foo Bar'));
    }

    /** @test */
    public function it_checks_if_empty()
    {
        $this->assertTrue(Str::isEmpty(''));

        $this->assertTrue(Str::isEmpty(null));

        $this->assertFalse(Str::isEmpty(0));

        $this->assertFalse(Str::isEmpty(false));
    }

    /** @test */
    public function it_checks_if_scalar()
    {
        $this->assertTrue(Str::isScalar('123'));
    }

    /** @test */
    public function it_splits()
    {
        $this->assertEquals([], Str::split(''));

        $this->assertEquals(['Foo', 'Bar'], Str::split('Foo Bar', ' ', 2));
    }

    /** @test */
    public function it_splits_path()
    {
        $this->assertEquals(['Foo', 'Bar'], Str::splitPath('Foo/Bar'));
    }

    /** @test */
    public function it_splits_quoted()
    {
        $this->assertEquals(['Foo', 'Bar'], Str::splitQuoted('"Foo", "Bar"'));
    }

    /** @test */
    public function it_parse()
    {
        $this->assertEquals(['foo' => 'foo', 'bar' => 'bar'], Str::parse('foo=foo&bar=bar'));

        $this->assertEquals(['foo' => 'foo', 'bar' => 'bar'], Str::parse('foo:=foo&&bar:=bar', '&&', ':='));
    }

    /** @test */
    public function it_generates_random_string()
    {
        $this->assertEquals(8, strlen(Str::generate(8)));
    }

    /** @test */
    public function it_transform_numbers_to_nth()
    {
        $this->assertEquals('1st', Str::nth(1));

        $this->assertEquals('2nd', Str::nth(2));

        $this->assertEquals('3rd', Str::nth(3));

        $this->assertEquals('17th', Str::nth(17));

        $this->assertEquals('54th', Str::nth(54));
    }

    /** @test */
    public function it_is_digit()
    {
        $this->assertTrue(Str::isDigit('123'));
    }

    /** @test */
    public function it_gets_system_name()
    {
        $this->assertEquals('inghetata-rece', Str::systemName('Înghețată rece'));
    }

    /** @test */
    public function it_parses_urls()
    {
        $this->assertEquals(
            'Search on <a href="http://google.com">google.com</a>',
            Str::parseUrls('Search on google.com', function ($url, $href) {
                return '<a href="' . $href . '">' . $url . '</a>';
            })
        );
    }
}
