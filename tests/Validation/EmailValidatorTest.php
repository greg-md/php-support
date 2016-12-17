<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\EmailValidator;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function email_should_be_valid()
    {
        $validation = new EmailValidator();

        $this->assertTrue(!$validation->validate('john@doe.com'));
    }

    /**
     * @test
     */
    public function any_other_string_should_not_be_valid()
    {
        $validation = new EmailValidator();

        $this->assertArrayHasKey('EmailError', $validation->validate('any string'));
    }
}
