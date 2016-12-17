<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\EqualValidator;
use PHPUnit\Framework\TestCase;

class EqualValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_if_is_equal()
    {
        $validation = new EqualValidator('foo');

        $this->assertTrue(! $validation->validate('bar', ['foo' => 'bar']));
    }

    /** @test */
    public function it_should_not_validate_if_is_not_equal()
    {
        $validation = new EqualValidator('foo');

        $this->assertArrayHasKey('EqualError', $validation->validate('big', ['foo' => 'bar']));
    }
}