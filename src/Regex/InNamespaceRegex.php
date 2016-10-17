<?php

namespace Greg\Support\Regex;

class InNamespaceRegex
{
    protected $start = null;

    protected $end = null;

    protected $recursive = false;

    protected $recursiveGroup = null;

    protected $capture = true;

    protected $capturedKey = null;

    protected $allowEmpty = true;

    protected $match = null;

    protected $escape = null;

    protected $disableIn = [];

    protected $newLines = false;

    protected $trim = false;

    public function __construct($start, $end = null, $recursive = false)
    {
        $this->setIn($start, $end);

        if ($recursive) {
            $this->recursive();
        }

        return $this;
    }

    public function setIn($start, $end = null)
    {
        $this->setStart($start);

        if ($end === null) {
            $end = $start;
        }

        $this->setEnd($end);

        return $this;
    }

    public function getIn()
    {
        return [$this->getStart(), $this->getEnd()];
    }

    public function setStart($value)
    {
        $this->start = (string) $value;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setEnd($value)
    {
        $this->end = (string) $value;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function disableInQuotes()
    {
        $this->disableIn("'");

        $this->disableIn('"');

        return $this;
    }

    public function disableIn($start = null, $end = null)
    {
        if (func_num_args()) {
            $this->disableIn[] = [$start, $end ?: $start];

            return $this;
        }

        return $this->disableIn;
    }

    public function recursive($type = true)
    {
        $this->recursive = (bool) $type;

        return $this;
    }

    public function isRecursive()
    {
        return (bool) $this->recursive;
    }

    public function setRecursiveGroup($value)
    {
        $this->recursiveGroup = (string) $value;

        return $this;
    }

    public function getRecursiveGroup()
    {
        return $this->recursiveGroup;
    }

    public function capture($value = true)
    {
        $this->capture = (bool) $value;

        return $this;
    }

    public function isCaptured()
    {
        return (bool) $this->capture;
    }

    public function setCapturedKey($value)
    {
        $this->capturedKey = (string) $value;
    }

    public function getCapturedKey()
    {
        return $this->capturedKey;
    }

    public function allowEmpty($value = true)
    {
        $this->allowEmpty = (bool) $value;

        return $this;
    }

    public function isAllowedEmpty()
    {
        return (bool) $this->allowEmpty;
    }

    public function setMatch($value)
    {
        $this->match = (string) $value;
    }

    public function getMatch()
    {
        return $this->match;
    }

    public function setEscape($value)
    {
        $this->escape = (string) $value;
    }

    public function getEscape()
    {
        return $this->escape;
    }

    public function newLines($value = true)
    {
        $this->newLines = (bool) $value;

        return $this;
    }

    public function isUsingNewLines()
    {
        return (bool) $this->newLines;
    }

    public function trim($value = true)
    {
        $this->trim = (bool) $value;

        return $this;
    }

    public function isTrimmed()
    {
        return (bool) $this->trim;
    }

    public function replaceCallback(callable $callable, $string, $flags = null)
    {
        return preg_replace_callback('#' . $this->toString() . '#' . $flags, $callable, $string);
    }

    public function toString()
    {
        $captureS = $captureE = null;

        if ($this->isCaptured()) {
            $captureS = '(';

            if ($capturedKey = $this->getCapturedKey()) {
                $captureS .= "?'{$capturedKey}'";
            }

            $captureE = ')';
        }

        $start = preg_quote($this->getStart());

        $end = preg_quote($this->getEnd());

        $allows = [];

        foreach ($this->disableIn as $capture) {
            $allows[] = preg_quote($capture[0]) . '.*?' . preg_quote($capture[1]);
        }

        if ($escape = $this->getEscape()) {
            // Allow escaped start
            $allows[] = "{$escape}{$start}";

            // Allow escaped end
            $allows[] = "{$escape}{$end}";
        }

        // Allow all instead of start and end
        $allows[] = "(?!{$start})(?!{$end}).";

        if ($this->isUsingNewLines()) {
            $allows[] = '\r?\n';
        }

        $matches = [
            $this->getMatch() ?: '(?:' . implode('|', $allows) . ')',
        ];

        if ($this->isRecursive()) {
            if ($recursiveGroup = $this->getRecursiveGroup()) {
                $matches[] = '\g\'' . $recursiveGroup . '\'';
            } else {
                $matches[] = '(?R)';
            }
        }

        $matches = implode('|', $matches);

        $flag = ($this->isAllowedEmpty() ? '*' : '+') . '?';

        $trim = $this->isTrimmed() ? '\s*' : '';

        $noEscaped = null;

        if ($escape) {
            $escape = preg_quote($escape);

            $noEscaped = "(?<!{$escape})";
        }

        return "{$noEscaped}{$start}{$trim}{$captureS}(?>{$matches}){$flag}{$captureE}{$trim}{$noEscaped}{$end}";
    }

    public function __toString()
    {
        return (string) $this->toString();
    }
}
