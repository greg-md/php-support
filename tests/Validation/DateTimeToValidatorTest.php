<?php

namespace Greg\Support\Tests\Validation;

use Greg\Support\Validation\DateTimeToValidator;
use PHPUnit\Framework\TestCase;

class DateTimeToValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function yesterday_should_be_less_than_today()
    {
        $validation = new DateTimeToValidator('today');

        $this->assertTrue(!$validation->validate('yesterday'));
    }

    /**
     * @test
     */
    public function today_should_be_less_or_equal_than_today()
    {
        $validation = new DateTimeToValidator('today', true);

        $this->assertTrue(!$validation->validate('today'));
    }

    /**
     * @test
     */
    public function empty_value_should_be_validated()
    {
        $validation = new DateTimeToValidator('today');

        $this->assertTrue(!$validation->validate(null));
    }

    /**
     * @test
     */
    public function today_should_not_be_less_than_yesterday()
    {
        $validation = new DateTimeToValidator('yesterday');

        $this->assertArrayHasKey('DateTimeToError', $validation->validate('today'));
    }
}
