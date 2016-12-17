<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\MaxValidator;
use PHPUnit\Framework\TestCase;

class MaxValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_if_is_less_or_equal_with()
    {
        $validation = new MaxValidator(10);

        $this->assertTrue(! $validation->validate(5));

        $this->assertTrue(! $validation->validate(10));
    }

    /** @test */
    public function it_should_not_validate_if_is_more_than()
    {
        $validation = new MaxValidator(10);

        $this->assertArrayHasKey('MaxError', $validation->validate(15));
    }
}