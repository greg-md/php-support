<?php

namespace Greg\Support\Tests\Regex;

use Greg\Support\Regex\InNamespaceRegex;
use PHPUnit\Framework\TestCase;

class InNamespaceRegexTest extends TestCase
{
    /**
     * @var InNamespaceRegex
     */
    protected $regex = null;

    public function setUp()
    {
        parent::setUp();

        $this->regex = new InNamespaceRegex('{{', '}}');
    }

    public function testInstance()
    {
        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).))*?)\}\}', $this->regex->toString());
    }

    public function testDisableInQuotes()
    {
        $this->regex->disableInQuotes();

        $this->assertEquals('\{\{((?>(?:\'.*?\'|".*?"|(?!\{\{)(?!\}\}).))*?)\}\}', $this->regex->toString());
    }

    public function testRecursive()
    {
        $this->regex->recursive();

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).)|(?R))*?)\}\}', $this->regex->toString());
    }

    public function testRecursiveGroup()
    {
        $this->regex->recursive()->setRecursiveGroup('foo');

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).)|\g\'foo\')*?)\}\}', $this->regex->toString());
    }

    public function testNoCapture()
    {
        $this->regex->capture(false);

        $this->assertEquals('\{\{(?>(?:(?!\{\{)(?!\}\}).))*?\}\}', $this->regex->toString());
    }

    public function testCapturedKey()
    {
        $this->regex->setCapturedKey('bar');

        $this->assertEquals('\{\{(?\'bar\'(?>(?:(?!\{\{)(?!\}\}).))*?)\}\}', $this->regex->toString());
    }

    public function testAllowEmpty()
    {
        $this->regex->allowEmpty();

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).))*?)\}\}', $this->regex->toString());
    }

    public function testMatch()
    {
        $this->regex->setMatch('bar');

        $this->assertEquals('\{\{((?>bar)*?)\}\}', $this->regex->toString());
    }

    public function testEscape()
    {
        $this->regex->setEscape('foo');

        $this->assertEquals('(?<!foo)\{\{((?>(?:foo\{\{|foo\}\}|(?!\{\{)(?!\}\}).))*?)(?<!foo)\}\}', $this->regex->toString());
    }

    public function testNewLines()
    {
        $this->regex->newLines();

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).|\r?\n))*?)\}\}', $this->regex->toString());
    }

    public function testTrim()
    {
        $this->regex->trim();

        $this->assertEquals('\{\{\s*((?>(?:(?!\{\{)(?!\}\}).))*?)\s*\}\}', $this->regex->toString());
    }
}
