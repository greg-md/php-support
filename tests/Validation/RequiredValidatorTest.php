<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\MinValidator;
use PHPUnit\Framework\TestCase;

class MinValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_if_number_is_greater_or_equal_with()
    {
        $validation = new MinValidator(10);

        $this->assertTrue(! $validation->validate(10));

        $this->assertTrue(! $validation->validate(15));
    }

    /** @test */
    public function it_should_not_validate_if_number_is_less_than()
    {
        $validation = new MinValidator(10);

        $this->assertArrayHasKey('MinError', $validation->validate(5));
    }
}