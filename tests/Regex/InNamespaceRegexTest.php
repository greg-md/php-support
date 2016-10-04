<?php

namespace Greg\Support\Tests\Regex;

use Greg\Support\Regex\InNamespaceRegex;
use PHPUnit\Framework\TestCase;

class InNamespaceRegexTest extends TestCase
{
    protected function newInstance()
    {
        return new InNamespaceRegex('{{', '}}');
    }

    public function testInstance()
    {
        $request = $this->newInstance();

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).))*?)\}\}', $request->toString());
    }

    public function testDisableInQuotes()
    {
        $request = $this->newInstance();

        $request->disableInQuotes();

        $this->assertEquals('\{\{((?>(?:\'.*?\'|".*?"|(?!\{\{)(?!\}\}).))*?)\}\}', $request->toString());
    }

    public function testRecursive()
    {
        $request = $this->newInstance();

        $request->recursive();

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).)|(?R))*?)\}\}', $request->toString());
    }

    public function testRecursiveGroup()
    {
        $request = $this->newInstance();

        $request->recursive()->setRecursiveGroup('foo');

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).)|\g\'foo\')*?)\}\}', $request->toString());
    }

    public function testNoCapture()
    {
        $request = $this->newInstance();

        $request->capture(false);

        $this->assertEquals('\{\{(?>(?:(?!\{\{)(?!\}\}).))*?\}\}', $request->toString());
    }

    public function testCapturedKey()
    {
        $request = $this->newInstance();

        $request->setCapturedKey('bar');

        $this->assertEquals('\{\{(?\'bar\'(?>(?:(?!\{\{)(?!\}\}).))*?)\}\}', $request->toString());
    }

    public function testAllowEmpty()
    {
        $request = $this->newInstance();

        $request->allowEmpty();

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).))*?)\}\}', $request->toString());
    }

    public function testMatch()
    {
        $request = $this->newInstance();

        $request->setMatch('bar');

        $this->assertEquals('\{\{((?>bar)*?)\}\}', $request->toString());
    }

    public function testEscape()
    {
        $request = $this->newInstance();

        $request->setEscape('foo');

        $this->assertEquals('(?<!foo)\{\{((?>(?:foo\{\{|foo\}\}|(?!\{\{)(?!\}\}).))*?)(?<!foo)\}\}', $request->toString());
    }

    public function testNewLines()
    {
        $request = $this->newInstance();

        $request->newLines();

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).|\r?\n))*?)\}\}', $request->toString());
    }

    public function testTrim()
    {
        $request = $this->newInstance();

        $request->trim();

        $this->assertEquals('\{\{\s*((?>(?:(?!\{\{)(?!\}\}).))*?)\s*\}\}', $request->toString());
    }
}