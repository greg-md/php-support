<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\EnumValidator;
use PHPUnit\Framework\TestCase;

class EnumValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function value_should_be_in_the_stack()
    {
        $validation = new EnumValidator([1, 2, 3]);

        $this->assertTrue(!$validation->validate(2));

        $this->assertTrue(!$validation->validate('2'));
    }

    /**
     * @test
     */
    public function strict_value_should_be_in_the_stack()
    {
        $validation = new EnumValidator([1, 2, 3], true);

        $this->assertTrue(!$validation->validate(2));

        $this->assertFalse(!$validation->validate('2'));
    }

    /**
     * @test
     */
    public function value_should_not_be_in_the_stack()
    {
        $validation = new EnumValidator([1, 2, 3]);

        $this->assertArrayHasKey('EnumError', $validation->validate(4));
    }
}
