<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\MaxLengthValidator;
use PHPUnit\Framework\TestCase;

class MaxLengthValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_if_is_less_than_length()
    {
        $validation = new MaxLengthValidator(6);

        $this->assertTrue(! $validation->validate('Hello'));
    }

    /** @test */
    public function it_should_not_validate_if_is_more_than_length()
    {
        $validation = new MaxLengthValidator(6);

        $this->assertArrayHasKey('MaxLengthError', $validation->validate('Hello World!'));
    }
}