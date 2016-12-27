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

class Foo
{
    use FooTrait;
}

class FooBar extends Foo
{
    use FooBarTrait;
}

class ObjTest extends TestCase
{
    /** @test */
    public function it_calls()
    {
        $this->assertEquals([1, 2, 3], Obj::call(function(...$args) {
            return $args;
        }, 1, 2, 3));

        $one = 1;

        $two = 2;

        $three = 3;

        $this->assertEquals([&$one, &$two, &$three], Obj::callRef(function(&...$args) {
            $args[0] *= -1;

            return $args;
        }, $one, $two, $three));
    }

    /** @test */
    public function it_calls_with_mixed_params()
    {
        $foo = new Foo();

        $this->assertEquals([$foo, 1, 2], Obj::callMixed(function(Foo $foo, $one, $two) {
            return func_get_args();
        }, 1, $foo, 2));

        $one = 1;

        $two = 2;

        $this->assertEquals([&$foo, &$one, &$two], Obj::callMixedRef(function(Foo $foo, &$one, $two) {
            $one *= -1;

            return func_get_args();
        }, $one, $foo, $two));
    }

    /** @test */
    public function it_gets_base_name()
    {
        $this->assertEquals('ObjTest', Obj::baseName(static::class));
    }

    /** @test */
    public function it_searches_for_a_class()
    {
        $this->assertEquals(FooBar::class, Obj::classExists('Bar', ['Greg\\Support\\Tests\\'], 'Foo'));
    }

    /** @test */
    public function it_searches_for_all_uses()
    {
        $uses = Obj::usesRecursive(FooBar::class);

        $this->assertArrayHasKey(FooTrait::class, $uses);

        $this->assertArrayHasKey(FooBarTrait::class, $uses);
    }

    /** @test */
    public function it_searches_for_parent_classes()
    {
        $classes = Obj::parentClasses(FooBar::class);

        $this->assertArrayHasKey(Foo::class, $classes);
    }
}
