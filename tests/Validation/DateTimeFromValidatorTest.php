<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\DateTimeFromValidator;
use PHPUnit\Framework\TestCase;

class DateTimeFromValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function tomorrow_should_be_grater_than_today()
    {
        $validation = new DateTimeFromValidator('today');

        $this->assertTrue(! $validation->validate('tomorrow'));
    }

    /**
     * @test
     */
    public function today_should_be_grater_or_equal_than_today()
    {
        $validation = new DateTimeFromValidator('today', true);

        $this->assertTrue(! $validation->validate('today'));
    }

    /**
     * @test
     */
    public function empty_value_should_be_validated()
    {
        $validation = new DateTimeFromValidator('today');

        $this->assertTrue(! $validation->validate(null));
    }

    /**
     * @test
     */
    public function today_should_not_be_greater_than_tomorrow()
    {
        $validation = new DateTimeFromValidator('tomorrow');

        $this->assertArrayHasKey('DateTimeFromError', $validation->validate('today'));
    }
}