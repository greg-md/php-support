<?php

namespace Greg\Support\Tests;

use Greg\Support\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function testToCurrentYearInterval()
    {
        $this->assertEquals('2014 - ' . date('Y'), DateTime::toCurrentYearInterval('2014'));
    }

    public function testFormatTime()
    {
        $this->assertEquals(date('Y-m-d H:i:s', strtotime('+1 year')), DateTime::formatTime('Y-m-d H:i:s', '+1 year'));
    }

    public function testFormatTimeLocale()
    {
        $this->assertEquals(strftime('%Y', strtotime('+1 year')), DateTime::formatTimeLocale('%Y', '+1 year'));
    }

    public function testDiffTime()
    {
        $this->assertEquals(1, DateTime::diffTime('tomorrow'));
    }

    public function testToDateTimeString()
    {
        $this->assertEquals(date('Y-m-d H:i', strtotime('tomorrow')), DateTime::toDateTimeString('tomorrow', false));
    }

    public function testToISO8601()
    {
        $this->assertEquals(date('c'), DateTime::toISO8601('now'));
    }

    public function testToDateString()
    {
        $this->assertEquals(date('Y-m-d'), DateTime::toDateString('now'));
    }

    public function testToTimeString()
    {
        $this->assertEquals(date('H:i:s'), DateTime::toTimeString('now'));
    }

    public function testToYearString()
    {
        $this->assertEquals(date('Y'), DateTime::toYearString('now'));

        $this->assertEquals(date('y'), DateTime::toYearString('now', false));
    }

    public function testToMonthString()
    {
        $this->assertEquals(date('m'), DateTime::toMonthString('now'));
    }

    public function testToDayString()
    {
        $this->assertEquals(date('d'), DateTime::toDayString('now'));
    }

    public function testUntilNowTime()
    {
        $this->assertEquals(2, DateTime::untilNowTime('-2 seconds'));
    }
}
