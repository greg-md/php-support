<?php

namespace Greg\Support\Tests\Tools;

use Greg\Support\Tools\Regex;
use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase
{
    /** @test */
    public function it_checks_canonical_division()
    {
        $regex = Regex::inNamespace('!');

        $this->assertEquals('\!((?>(?:(?!\!)(?!\!).))*?)\!', $regex->toString());
    }

    /** @test */
    public function it_disables_groups()
    {
        $this->assertEquals('(?:a)', Regex::disableGroups('(a)'));
    }

    /** @test */
    public function it_quotes_a_string()
    {
        $this->assertEquals('\#', Regex::quote('#'));
    }

    /** @test */
    public function it_changes_default_delimiter()
    {
        Regex::setDelimiter('/');

        $this->assertEquals('/', Regex::getDelimiter());
    }
}
