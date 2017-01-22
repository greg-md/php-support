<?php

namespace Greg\Support\Tests\Tools;

use Greg\Support\Tools\InNamespaceRegex;
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

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).))*?)\}\}', (string) $this->regex);
    }

    public function testSingle()
    {
        $regex = new InNamespaceRegex('!');

        $this->assertEquals('\!((?>(?:(?!\!)(?!\!).))*?)\!', $regex->toString());

        $this->assertEquals('\!((?>(?:(?!\!)(?!\!).))*?)\!', (string) $regex);

        $this->assertEquals(['!', '!'], $regex->getIn());

        $this->assertEquals('[a]', $regex->replaceCallback(function ($matches) {
            return '[' . $matches[1] . ']';
        }, '!a!'));
    }

    public function testDisableInQuotes()
    {
        $this->regex->disableInQuotes();

        $this->assertEquals('\{\{((?>(?:\'.*?\'|".*?"|(?!\{\{)(?!\}\}).))*?)\}\}', $this->regex->toString());

        $this->assertEquals([
            ["'", "'"],
            ['"', '"'],
        ], $this->regex->getDisabledIn());
    }

    public function testRecursive()
    {
        $regex = new InNamespaceRegex('{{', '}}', true);

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).)|(?R))*?)\}\}', $regex->toString());
    }

    public function testRecursiveGroup()
    {
        $this->regex->recursive('foo');

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).)|\g\'foo\')*?)\}\}', $this->regex->toString());
    }

    public function testNoCapture()
    {
        $this->regex->capture(false);

        $this->assertEquals('\{\{(?>(?:(?!\{\{)(?!\}\}).))*?\}\}', $this->regex->toString());
    }

    public function testCapturedKey()
    {
        $this->regex->capture('bar');

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
