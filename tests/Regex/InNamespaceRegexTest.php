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

        $request->recursive(true);

        $this->assertEquals('\{\{((?>(?:(?!\{\{)(?!\}\}).)|(?R))*?)\}\}', $request->toString());
    }
}