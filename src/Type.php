<?php

namespace Greg\Support;

class Type
{
    static public function isNaturalNumber($var)
    {
        return ctype_digit((string)$var);
    }
}