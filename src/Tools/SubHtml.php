<?php

namespace Greg\Support\Tools;

class SubHtml
{
    private $start = 0;

    private $length = null;

    private $delimiter = [];

    private $suffix = null;

    private $forceSuffix = null;

    private $html;

    private $textLength;

    private $newHtml;

    private $remainHtml;

    private $stringLength;

    private $usedDelimiter;

    private $htmlLength;

    public function __construct($start = 0, $length = null, $delimiter = null, $suffix = null, $forceSuffix = false)
    {
        $this->setStart($start);

        $this->setLength($length);

        $this->setDelimiter($delimiter);

        $this->setSuffix($suffix);

        $this->forceSuffix($forceSuffix);
    }

    public function setStart($position)
    {
        $this->start = (int) $position;

        return $this;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setLength($length)
    {
        $this->length = (int) $length;

        return $this;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setDelimiter($delimiter)
    {
        $this->delimiter = (string) $delimiter;

        return $this;
    }

    public function getDelimiter()
    {
        return $this->delimiter;
    }

    public function setSuffix($suffix)
    {
        $this->suffix = (int) $suffix;

        return $this;
    }

    public function getSuffix()
    {
        return $this->suffix;
    }

    public function forceSuffix($force = true)
    {
        $this->forceSuffix = (bool) $force;

        return $this;
    }

    public function isSuffixForced()
    {
        return $this->forceSuffix;
    }

    public function parse($html)
    {
        $this->reset($html);

        return $this->fetch();
    }

    protected function reset($html)
    {
        $this->html = $html;

        $this->textLength = $this->textLength($html);

        $this->htmlLength = $this->htmlLength($html);

        $this->newHtml = $this->remainHtml = null;

        $this->stringLength = 0;

        $this->usedDelimiter = null;
    }

    protected function textLength($html)
    {
        return mb_strlen(strip_tags($this->htmlEntityDecode($html)));
    }

    protected function htmlLength($html)
    {
        if (!$length = $this->length) {
            $length = mb_strlen($this->htmlEntityDecode($html)) - $this->start;
        }

        return $length;
    }

    protected function htmlEntityDecode($html)
    {
        return html_entity_decode($html, ENT_QUOTES, 'UTF-8');
    }

    protected function fetch()
    {
        if (!$this->textLength) {
            return $this->html;
        }

        $this->html = '>' . $this->html . '<';

        preg_replace_callback('#>([^<]+)<#s', function ($matches) {
            return $this->matches($matches);
        }, $this->html);

        return $this->clean($this->html);
    }

    protected function matches($matches)
    {
        $matchedSubstring = $this->matchedSubstring($matches[0]);

        $this->html = '>' . mb_substr($this->html, mb_strlen($matchedSubstring) + 1 + mb_strlen($matches[1]));

        if ($this->stringLength >= $this->htmlLength and (!$this->delimiter or $this->usedDelimiter)) {
            $this->remainHtml .= $matchedSubstring;

            return '><';
        }

        $this->addNewHtml($matchedSubstring);

        $string = $this->htmlEntityDecode($matches[1]);

        if (($stringLength = mb_strlen($string)) <= $this->substringLength()) {
            $this->stringLength += $stringLength;

            return '><';
        }

        return $this->cleanMatched($string, $this->remainDelimiter($string));
    }

    protected function substringLength()
    {
        return max(0, ($this->start - $this->stringLength));
    }

    protected function addNewHtml($string)
    {
        if ($this->substringLength()) {
            $string = $this->removeEmptyTags($string);
        }

        $this->newHtml .= $string;

        return $this;
    }

    protected function matchedSubstring($matched)
    {
        if ($matchedPosition = mb_strpos($this->html, $matched)) {
            return mb_substr($this->html, 1, $matchedPosition);
        }

        return '';
    }

    protected function remainDelimiter($string)
    {
        $remainLength = $this->remainLength();

        $stringLength = mb_strlen($string);

        if ($this->delimiter and $stringLength > $remainLength) {
            $offset = $remainLength + $this->substringLength();

            $delimiterPosition = false;

            if ($offset < $stringLength) {
                $offset -= 1;

                if ($offset < 0) {
                    $offset = 0;
                }

                $delimiterPosition = $this->findDelimiter($string, $offset);
            }

            $remainLength = $delimiterPosition !== false ? $delimiterPosition : $stringLength;
        }

        return $remainLength;
    }

    protected function findDelimiter($string, $offset)
    {
        foreach ($this->delimiter as $del) {
            $position = mb_strpos($string, $del, $offset);

            if ($position !== false) {
                $this->usedDelimiter = $del;

                return $position;
            }
        }

        return false;
    }

    protected function remainLength()
    {
        $length = $this->htmlLength - $this->stringLength;

        if ($length < 0) {
            $length = 0;
        }

        return $length;
    }

    protected function cleanMatched($string, $length)
    {
        $string = mb_substr($string, $this->substringLength(), $length);

        $this->stringLength += mb_strlen($string);

        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');

        if ($this->canUseSuffix($length)) {
            $string .= str_replace('{delimiter}', $this->usedDelimiter, $this->suffix);
        }

        $this->newHtml .= $string;

        return '>' . $string . '<';
    }

    protected function canUseSuffix($length)
    {
        return (
            $this->forceSuffix and $this->stringLength >= $this->textLength
        ) or (
            $this->suffix and $this->stringLength >= $length and (!$this->delimiter or $this->usedDelimiter)
        );
    }

    protected function clean($html)
    {
        $html = trim(rtrim(ltrim($html, '>'), '<'));

        return $this->newHtml . ($this->remainHtml ? $this->removeEmptyTags($this->remainHtml . $html) : $html);
    }

    protected function removeEmptyTags($html)
    {
        while (true) {
            $replaced = preg_replace([
                '#<[^/][^>]*/>#s',
                '#<([^\s>]*)(\b)?[^>]*(?<!/)></\1>#si',
                '#<(area|base|br|col|command|embed|hr|img|input|keygen|link|meta|param|source|track|wbr|basefont|bgsound|frame|isindex)\b[^>]*>#si',
            ], '', $html);

            if ($replaced == $html) {
                break;
            }

            $html = $replaced;
        }

        return $html;
    }
}
