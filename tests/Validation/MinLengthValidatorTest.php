<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\MinLengthValidator;
use PHPUnit\Framework\TestCase;

class MinLengthValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_if_length_is_greater_than_length()
    {
        $validation = new MinLengthValidator(6);

        $this->assertTrue(! $validation->validate('Hello!'));
    }

    /** @test */
    public function it_should_not_validate_if_length_is_less_than_length()
    {
        $validation = new MinLengthValidator(6);

        $this->assertArrayHasKey('MinLengthError', $validation->validate('Hello'));
    }
}