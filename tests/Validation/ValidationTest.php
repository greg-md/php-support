<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\Validation;
use Greg\Support\Validation\ValidationException;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    /** @test */
    public function it_should_validate_params()
    {
        $validation = new Validation([
            'foo' => 'required',
            'foo2' => ['required', ['min', 10]],
        ], 'Greg\\Support\\Validation', 'Validator');

        $this->assertTrue(! $validation->validate(['foo' => 'bar', 'foo2' => 20]));
    }

    /** @test */
    public function it_should_not_found_validator_class()
    {
        $validation = new Validation([
            'foo' => 'notFound',
        ]);

        $this->expectException(ValidationException::class);

        $this->assertTrue(! $validation->validate(['foo' => 'bar']));
    }
}