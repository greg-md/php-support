<?php

namespace Greg\Support\Tests;

use Greg\Support\Obj;
use PHPUnit\Framework\TestCase;

trait FooTrait
{
}

trait FooBarTrait
{
}

interface FooInterface
{
}

class Foo implements FooInterface
{
    use FooTrait;
}

function foo_function(Foo $foo)
{
    return func_get_args();
}

class FooBar extends Foo
{
    use FooBarTrait;

    public static function fooBarMethod()
    {
        return func_get_args();
    }
}

class ObjTest extends TestCase
{
    /** @test */
    public function it_gets_base_name()
    {
        $this->assertEquals('ObjTest', Obj::baseName(static::class));
    }

    /** @test */
    public function it_searches_for_a_class()
    {
        $this->assertEquals(FooBar::class, Obj::exists('Foo', ['Greg\\Support\\Tests\\'], 'Bar'));

        $this->assertFalse(Obj::exists('Undefined', ['Greg\\Support\\Tests\\'], 'Bar'));
    }

    /** @test */
    public function it_searches_for_all_uses()
    {
        $uses = Obj::usesRecursive(FooBar::class);

        $this->assertArrayHasKey(FooBarTrait::class, $uses);

        $this->assertArrayHasKey(FooTrait::class, $uses);

        $uses = Obj::usesRecursive(FooBar::class, Foo::class);

        $this->assertArrayHasKey(FooBarTrait::class, $uses);

        $this->assertArrayNotHasKey(FooTrait::class, $uses);
    }
}
