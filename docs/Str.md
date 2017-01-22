# String Documentation

`\Greg\Support\Str` is working with strings.

# Table of contents:

* [Methods](#methods)

# Methods:

* [camelCase](#camelcase) - Transform a string to `CamelCase`;
* [lowerCamelCase](#lowercamelcase) - Transform a string to `lowerCamelCase`;
* [snakeCase](#snakecase) - Transform a string to `SnakE_cASe`;
* [lowerSnakeCase](#lowersnakecase) - Transform a string to `lower_snake_case`;
* [upperSnakeCase](#uppersnakecase) - Transform a string to `UPPER_SNAKE_CASE`;
* [upperWordsSnakeCase](#upperwordssnakecase) - Transform a string to `Upper_Words_Snake_Case`;
* [kebabCase](#kebabcase) - Transform a string to `KebaB-cASe`;
* [spinalCase](#spinalcase) - Transform a string to `spinal-case`;
* [trainCase](#traincase) - Transform a string to `Train-Case`;
* [lispCase](#lispcase) - Transform a string to `Lisp-case`;
* [phpCamelCase](#phpcamelcase) - Transform a string to `PhpCamelCase`;
* [phpLowerCamelCase](#phplowercamelcase) - Transform a string to `phpLowerCamelCase`;
* [phpSnakeCase](#phpsnakecase) - Transform a string to `PHP_SnakE_cASe`;
* [phpLowerSnakeCase](#phplowersnakecase) - Transform a string to `php_lower_snake_case`;
* [phpUpperSnakeCase](#phpuppersnakecase) - Transform a string to `PHP_UPPER_SNAKE_CASE`;
* [phpUpperWordsSnakeCase](#phpupperwordssnakecase) - Transform a string to `Php_Upper_Words_Snake_Case`;
* [abbreviation](#abbreviation) - Transform a string to an abbreviation;
* [replaceLetters](#replaceletters) - Replace letters of a string. Keep cases;
* [replaceAccents](#replaceaccents) - Replace accents of a string;
* [is](#is) - Determine if a given string matches a given pattern;
* [startsWith](#startswith) - Determine if a given string starts with a given substring;
* [endsWith](#endswith) - Determine if a given string ends with a given substring;
* [shift](#shift) - Shift a string off from the beginning of the string;
* [quote](#quote) - Quote a string;
* [split](#split) - Split a string;
* [splitPath](#splitpath) - Split a string path;
* [splitQuoted](#splitquoted) - Split quoted values in a string;
* [parse](#parse) - Parse a string;
* [generate](#generate) - Generate a cryptographically secure pseudo-random string;
* [nth](#nth) - Get the nth of a number;
* [systemName](#systemname) - Transform a string to a system name;
* [parseUrls](#parseurls) - Parse URLs from a string;
* [isEmpty](#isempty) - Determine if a variable is empty;
* [isScalar](#isscalar) - Determine if a variable is scalar;
* [isDigit](#isdigit) - Determine if a string is a digit.

## camelCase

Transform a string to `CamelCase`.

```php
camelCase(string $string): string
```

`$string` - The string.

_Example:_

```php
\Greg\Support\Str::camelCase('camel case'); // result: CamelCase
```

## lowerCamelCase

Transform a string to `lowerCamelCase`.

```php
lowerCamelCase(string $string): string
```

`$string` - The string.

_Example:_

```php
\Greg\Support\Str::lowerCamelCase('lower camel case'); // result: lowerCamelCase
```

## snakeCase

Transform a string to `SnakE_cASe`.

```php
snakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::snakeCase('SnakE cASe'); // result: SnakE_cASe
```

## lowerSnakeCase

Transform a string to `lower_snake_case`.

```php
lowerSnakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::lowerSnakeCase('Lower SnakE cASe'); // return: lower_snake_case
```

## upperSnakeCase

Transform a string to `UPPER_SNAKE_CASE`.

```php
upperSnakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::upperSnakeCase('Upper SnakE cASe'); // return: UPPER_SNAKE_CASE
```

## upperWordsSnakeCase

Transform a string to `Upper_Words_Snake_Case`.

```php
upperWordsSnakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::upperWordsSnakeCase('Upper words SnakE cASe'); // return: Upper_Words_Snake_Case
```

## kebabCase

Transform a string to `KebaB-cASe`.

```php
kebabCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::kebabCase('KebaB cASe'); // return: KebaB-cASe
```

## spinalCase

Transform a string to `spinal-case`.

```php
spinalCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::spinalCase('SpinaL cASe'); // return: spinal-case
```

## trainCase

Transform a string to `Train-Case`.

```php
trainCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::trainCase('TraiN cASe'); // return: Train-Case
```

## lispCase

Transform a string to `Lisp-case`.

```php
lispCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::lispCase('LisP cASe'); // return: Lisp-case
```

## phpCamelCase

Transform a string to `PhpCamelCase`.

```php
phpCamelCase(string $string): string
```

`$string` - The string.

_Example:_

```php
\Greg\Support\Str::phpCamelCase('1 php camel case'); // result: _1PhpCamelCase
```

## phpLowerCamelCase

Transform a string to `phpLowerCamelCase`.

```php
phpLowerCamelCase(string $string): string
```

`$string` - The string.

_Example:_

```php
\Greg\Support\Str::phpLowerCamelCase('1 php lower camel case'); // result: _1PhpLowerCamelCase
```

## phpSnakeCase

Transform a string to `PHP_SnakE_cASe`.

```php
phpSnakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::phpSnakeCase('1 PHP SnakE cASe'); // result: _1_PHP_SnakE_cASe
```

## phpLowerSnakeCase

Transform a string to `php_lower_snake_case`.

```php
phpLowerSnakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::phpLowerSnakeCase('1 PHP Lower SnakE cASe'); // return: 1_php_lower_snake_case
```

## phpUpperSnakeCase

Transform a string to `PHP_UPPER_SNAKE_CASE`.

```php
phpUpperSnakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::phpUpperSnakeCase('1 PHP Upper SnakE cASe'); // return: _1_PHP_UPPER_SNAKE_CASE
```

## phpUpperWordsSnakeCase

Transform a string to `Php_Upper_Words_Snake_Case`.

```php
phpUpperWordsSnakeCase(string $string, boolean $splitCamelCase = false): string
```

`$string` - The string;  
`$splitCamelCase` - Split camel case.

_Example:_

```php
\Greg\Support\Str::phpUpperWordsSnakeCase('1 PHP Upper words SnakE cASe'); // return: _1_Php_Upper_Words_Snake_Case
```

## abbreviation

Transform a string to an abbreviation.

```php
abbreviation(string $string): string
```

`$string` - The string;

_Example:_

```php
\Greg\Support\Str::abbreviation('Federal Bureau of Investigation'); // return: FBI
```

## replaceLetters

Replace letters of a string. Keep cases.

```php
replaceLetters(string $string, string $search, string $replace): string
```

`$string` - The string;  
`$search` - Letters;  
`$replace` - Replacement.

_Example:_

```php
\Greg\Support\Str::replaceLetters('Înger', 'î', 'i'); // return: Inger
```

## replaceAccents

Replace letters of a string. Keep cases.

```php
replaceAccents(string $string): string
```

`$string` - The string.

_Example:_

```php
\Greg\Support\Str::replaceAccents('Înghețată'); // return: Inghetata
```

## is

Determine if a given string matches a given pattern.

```php
is(string $string, string $pattern): boolean
```

`$string` - The string;  
`$pattern` - String pattern.

_Example:_

```php
\Greg\Support\Str::is('Foo Bar', "Foo *"); // return: true
\Greg\Support\Str::is('Foo Bar', "* Foo"); // return: false
```

## startsWith

Determine if a given string starts with a given substring.

```php
startsWith(string $string, string|array $needles): boolean
```

`$string` - The string;  
`$needles` - Needles.

_Example:_

```php
\Greg\Support\Str::startsWith('Foo Bar', "Foo"); // return: true
\Greg\Support\Str::startsWith('Foo Bar', "Bar"); // return: false
```

## endsWith

Determine if a given string ends with a given substring.

```php
endsWith(string $string, string|array $needles): boolean
```

`$string` - The string;  
`$needles` - Needles.

_Example:_

```php
\Greg\Support\Str::endsWith('Foo Bar', "Bar"); // return: true
\Greg\Support\Str::endsWith('Foo Bar', "Foo"); // return: false
```

## shift

Shift a string off from the beginning of the string.

```php
shift(string $string, string $shift): string
```

`$string` - The string;  
`$shift` - Shift string.

_Example:_

```php
\Greg\Support\Str::shift('Foo Bar', "Foo "); // return: Bar
\Greg\Support\Str::shift('Foo Bar', "Baz "); // return: Bar
```

## quote

Quote a string.

```php
quote(string $string, string $start = '"', string $end = null): string
```

`$string` - The string;  
`$start` - Start with;  
`$end` - End with. If empty, uses `$start`.

_Example:_

```php
\Greg\Support\Str::quote('Foo Bar'); // return: "Foo Bar"
\Greg\Support\Str::quote('Foo Bar', "'"); // return: 'Foo Bar'
\Greg\Support\Str::quote('Foo Bar', '<', '>'); // return: <Foo Bar>
```

## split

Split a string.

```php
split(string $string, string $delimiter = '', int $limit = null): array
```

`$string` - The string;  
`$delimiter` - Delimiter;  
`$limit` - Limit.

_Example:_

```php
\Greg\Support\Str::split('Foo'); // return: ['F', 'o', 'o']
\Greg\Support\Str::split('Foo Bar', ' '); // return: ['Foo', 'Bar']
```

## splitPath

Split a string path.

```php
splitPath(string $string, int $limit = null): array
```

`$string` - The string;  
`$limit` - Limit.

_Example:_

```php
\Greg\Support\Str::splitPath('/foo/bar'); // return: ['foo', 'bar']
```

## splitQuoted

Split quoted values in a string.

```php
splitQuoted(string $string, string $delimiter = ',', string $quotes = '"'): array
```

`$string` - The string;  
`$delimiter` - Delimiter;  
`$quotes` - Quotes.

_Example:_

```php
\Greg\Support\Str::splitQuoted('"foo", "bar"'); // return: ['foo', 'bar']
```

## parse

Parse a string.

```php
parse(string $string, string $delimiter = '&', string $keyValueDelimiter = '='): array
```

`$string` - The string;  
`$limit` - Limit.

_Example:_

```php
\Greg\Support\Str::parse('foo=1&bar=2'); // return: ['foo' => 1, 'bar' => 2]
```

## generate

Generate a cryptographically secure pseudo-random string.

```php
generate(int $length, string $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'): string
```

`$length` - Length of the string;  
`$characters` - Characters list.

_Example:_

```php
\Greg\Support\Str::generate(6); // return: vfEvk4
\Greg\Support\Str::generate(6); // return: A6nDO1
```

## nth

Get the nth of a number.

```php
nth(int $number): string
```

`$number` - The number.

_Example:_

```php
\Greg\Support\Str::nth(1); // return: 1st
\Greg\Support\Str::nth(2); // return: 2nd
\Greg\Support\Str::nth(3); // return: 3rd
```

## systemName

Transform a string to a system name.

```php
systemName(int $number): string
```

`$number` - The number.

_Example:_

```php
\Greg\Support\Str::systemName('Foo bar.'); // return: foo-bar
\Greg\Support\Str::systemName('Înger înghețată.'); // return: inger-inghetata
```

## parseUrls

Parse URLs from a string.

```php
parseUrls(string $string, callable(string $url, string $href): string $callable): string
```

`$string` - The string;  
`$callable` - A callable to transform decorate de URL.  
&nbsp;&nbsp;&nbsp;&nbsp;`$url` - Original URL;  
&nbsp;&nbsp;&nbsp;&nbsp;`$href` - Absolute URL.

_Example:_

```php
$result = parseUrls('Search on google.com', function ($url, $href) {
    return '<a href="' . $href . '">' . $url . '</a>';
})

// $result: Search on <a href="http://google.com">google.com</a>
```

## isEmpty

Determine if a variable is empty.

```php
isEmpty(mixed $var): boolean
```

`$var` - The variable.

_Example:_

```php
\Greg\Support\Str::isEmpty(''); // return: true
\Greg\Support\Str::isEmpty(null); // return: true
\Greg\Support\Str::isEmpty("not empty"); // return: flase
\Greg\Support\Str::isEmpty(false); // return: flase
```

## isScalar

Determine if a variable is scalar.

```php
isScalar(mixed $var): boolean
```

`$var` - The variable.

_Example:_

```php
\Greg\Support\Str::isScalar(''); // return: true
\Greg\Support\Str::isScalar(null); // return: true
\Greg\Support\Str::isScalar(function() {}); // return: false
```

## isDigit

Determine if a string is a digit.

```php
isDigit(mixed $var): boolean
```

`$var` - The variable.

_Example:_

```php
\Greg\Support\Str::isDigit(1); // return: true
\Greg\Support\Str::isDigit('12'); // return: true
\Greg\Support\Str::isDigit(true); // return: true
\Greg\Support\Str::isDigit(false); // return: true
\Greg\Support\Str::isDigit('1a'); // return: false
```
