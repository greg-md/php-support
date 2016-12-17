<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\IntValidator;
use PHPUnit\Framework\TestCase;

class IntValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_any_int()
    {
        $validation = new IntValidator();

        $this->assertTrue(! $validation->validate(1));

        $this->assertTrue(! $validation->validate('2'));

        $this->assertTrue(! $validation->validate(-1));
    }

    /** @test */
    public function it_should_validate_unsigned_int()
    {
        $validation = new IntValidator();

        $this->assertTrue(! $validation->validate(1));

        $this->assertTrue(! $validation->validate('2'));
    }

    /** @test */
    public function it_should_not_validate_signed_int()
    {
        $validation = new IntValidator(true);

        $this->assertArrayHasKey('IntUnsignedError', $validation->validate(-1));
    }

    /** @test */
    public function it_should_not_validate_any_other_values()
    {
        $validation = new IntValidator();

        $this->assertArrayHasKey('IntError', $validation->validate(1.5));

        $this->assertArrayHasKey('IntError', $validation->validate('foo'));
    }
}