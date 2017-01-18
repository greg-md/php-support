# String Documentation

`\Greg\Support\Str` is working with strings.

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
* [replaceLetters](#replaceletters) - Replace letters of a string. Ignore cases;
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
* [isDigit](#isdigit) - Determine if a string is a digit;

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
