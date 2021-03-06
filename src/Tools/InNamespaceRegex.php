<?php

namespace Greg\Support\Tools;

class InNamespaceRegex
{
    protected $start = null;

    protected $end = null;

    protected $recursive = false;

    protected $disableIn = [];

    protected $capture = true;

    protected $allowEmpty = true;

    protected $match = null;

    protected $escape = null;

    protected $newLines = false;

    protected $trim = false;

    public function __construct($start, $end = null, $recursive = null)
    {
        $this->setIn($start, $end);

        if ($recursive !== null) {
            $this->recursive($recursive);
        }

        return $this;
    }

    public function setIn($start, $end = null)
    {
        if ($end === null) {
            $end = $start;
        }

        return $this->setStart($start)->setEnd($end);
    }

    public function getIn()
    {
        return [$this->getStart(), $this->getEnd()];
    }

    public function setStart($value)
    {
        $this->start = (string) $value;

        return $this;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setEnd($value)
    {
        $this->end = (string) $value;

        return $this;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function recursive($type = true)
    {
        $this->recursive = $type;

        return $this;
    }

    public function isRecursive()
    {
        return (bool) $this->recursive;
    }

    public function disableIn($start, $end = null)
    {
        if ($end === null) {
            $end = $start;
        }

        $this->disableIn[] = [$start, $end];

        return $this;
    }

    public function disableInQuotes()
    {
        return $this->disableIn("'")->disableIn('"');
    }

    public function getDisabledIn()
    {
        return $this->disableIn;
    }

    public function capture($value = true)
    {
        $this->capture = $value;

        return $this;
    }

    public function hasCapture()
    {
        return (bool) $this->capture;
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

        return $this;
    }

    public function getMatch()
    {
        return $this->match;
    }

    public function setEscape($value)
    {
        $this->escape = (string) $value;

        return $this;
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

    public function isAllowedNewLines()
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

        if ($this->capture) {
            $captureS = '(';

            if ($this->capture !== true) {
                $captureS .= "?'" . preg_quote($this->capture) . "'";
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

        if ($this->isAllowedNewLines()) {
            $allows[] = '\r?\n';
        }

        $matches = [
            $this->getMatch() ?: '(?:' . implode('|', $allows) . ')',
        ];

        if ($this->recursive) {
            $matches[] = $this->recursive === true ? '(?R)' : '\g\'' . $this->recursive . '\'';
        }

        $matches = implode('|', $matches);

        $flag = ($this->allowEmpty ? '*' : '+') . '?';

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
