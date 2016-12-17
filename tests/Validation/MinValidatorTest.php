<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\RequiredValidator;
use PHPUnit\Framework\TestCase;

class RequiredValidatorTest extends TestCase
{
    /** @test */
    public function it_should_validate_if_not_empty()
    {
        $validation = new RequiredValidator();

        $this->assertTrue(! $validation->validate('foo'));
    }

    /** @test */
    public function it_should_not_validate_if_empty()
    {
        $validation = new RequiredValidator();

        $this->assertArrayHasKey('RequiredError', $validation->validate(''));
    }
}