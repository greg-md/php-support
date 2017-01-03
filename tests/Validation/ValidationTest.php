<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\Validation;
use Greg\Support\Validation\ValidationException;
use Greg\Support\Validation\ValidatorStrategy;
use PHPUnit\Framework\TestCase;

class InvalidValidator
{

}

class ValidationTest extends TestCase
{
    /** @test */
    public function it_should_validate_params()
    {
        $validation = new Validation([
            'foo'  => 'required',
            'foo2' => ['required', ['min', 10]],
        ], 'Greg\\Support\\Validation', 'Validator');

        $this->assertTrue(!$validation->validate(['foo' => 'bar', 'foo2' => 20]));
    }

    /** @test */
    public function it_should_not_found_validator_class()
    {
        $validation = new Validation([
            'foo' => 'notFound',
        ]);

        $this->expectException(ValidationException::class);

        $this->expectExceptionMessage('Validator `notFound` not found.');

        $validation->validate(['foo' => 'bar']);
    }

    /** @test */
    public function it_throw_an_invalid_validator()
    {
        $validation = new Validation([
            'foo' => new InvalidValidator(),
        ]);

        $this->expectException(ValidationException::class);

        $this->expectExceptionMessage('Validator `' . InvalidValidator::class . '` should be an instance of `' . ValidatorStrategy::class . '`.');

        $validation->validate(['foo' => 'bar']);
    }
}
