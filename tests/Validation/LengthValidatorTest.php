<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\LengthValidator;
use PHPUnit\Framework\TestCase;

class LengthValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_the_same_length()
    {
        $validation = new LengthValidator(5);

        $this->assertTrue(!$validation->validate('Hello'));
    }

    /** @test */
    public function it_should_not_validate_different_length()
    {
        $validation = new LengthValidator(5);

        $this->assertArrayHasKey('LengthError', $validation->validate('Hello World!'));
    }
}
