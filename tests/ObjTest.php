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
    public function it_calls()
    {
        $this->assertEquals([1, 2, 3], Obj::call(function ($a, $b, $c, $foo = null) {
            return func_get_args();
        }, 1, 2, 3));

        $this->assertEquals([1, 2, 3], Obj::call(function (...$args) {
            return $args;
        }, 1, 2, 3));

        $one = 1;

        $two = 2;

        $three = 3;

        $this->assertEquals([&$one, &$two, &$three], Obj::callRef(function (&...$args) {
            $args[0] *= -1;

            return $args;
        }, $one, $two, $three));
    }

    /** @test */
    public function it_calls_with_mixed_params()
    {
        $foo = new Foo();

        $this->assertEquals([$foo, 1, 2], Obj::callMixed(function (Foo $foo, $one, $two, $three = 3) {
            return func_get_args();
        }, 1, $foo, 2));

        $this->assertEquals([1, 2, null], Obj::callMixed(function ($one, $two, Foo $foo = null) {
            return func_get_args();
        }, 1, 2));

        $this->assertEquals([1, 2, 2, $foo], Obj::callMixed(function ($one, $lol, $two, Foo $foo, $three = 3) {
            return func_get_args();
        }, 1, $foo, 2));

        $this->assertEquals([1, $foo, 2], Obj::callMixed(function (...$args) {
            return $args;
        }, 1, $foo, 2));

        $one = 1;

        $two = 2;

        $this->assertEquals([&$foo, &$one, &$two], Obj::callMixedRef(function (Foo $foo, &$one, $two) {
            $one *= -1;

            return func_get_args();
        }, $one, $foo, $two));

        $this->assertEquals([], Obj::callMixed(function () {
            return func_get_args();
        }));

        $this->assertEquals([], Obj::callMixed(FooBar::class . '::fooBarMethod'));
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

        $this->assertFalse(Obj::classExists('Undefined', ['Greg\\Support\\Tests\\'], 'Foo'));
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

    /** @test */
    public function it_searches_for_parent_classes()
    {
        $classes = Obj::parentClasses(FooBar::class);

        $this->assertArrayHasKey(Foo::class, $classes);
    }

    /** @test */
    public function it_throws_exception_if_arg_type_is_required()
    {
        $this->expectException(\Exception::class);

        $this->expectExceptionMessage('Argument `foo` is required in `Greg\Support\Tests\ObjTest::Greg\Support\Tests\{closure}`.');

        Obj::callMixed(function (Foo $foo) {
            return func_get_args();
        });
    }

    /** @test */
    public function it_throws_exception_if_arg_type_is_required_in_a_function()
    {
        $this->expectException(\Exception::class);

        $this->expectExceptionMessage('Argument `foo` is required in `Greg\Support\Tests\foo_function`.');

        Obj::callMixed('Greg\Support\Tests\foo_function');
    }
}
