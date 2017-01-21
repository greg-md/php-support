# Validation Documentation

`\Greg\Support\Validation\Validation` validate parameters against validators.

Throws: `\Greg\Support\Validation\ValidationException`.

# Methods:

* [addValidators](#addValidators) - Add validators;
* [addPrefix](#addPrefix) - Add a prefix or an array of prefixes;
* [addSuffix](#addPrefix) - Add a suffix or an array of suffixes;
* [validate](#validate) - Validate parameters;

# Validators

* [dateTimeFrom](#dateTimeFrom) - Validate a `DateTime` to be grater than another `DateTime`;
* [dateTimeTo](#dateTimeTo) - Validate a `DateTime` to be less than another `DateTime`;
* [email](#email) - Validate an email address;
* [enum](#enum) - Validate a value to exists in a stack;
* [equal](#equal) - Validate a value to be equal with another value;
* [int](#int) - Validate a value to be an integer;
* [length](#length) - Validate a string length;
* [maxLength](#maxLength) - Validate a string maximum length;
* [minLength](#minLength) - Validate a string minimum length;
* [max](#max) - Validate a number to be less than another number;
* [min](#min) - Validate a number to be greater than another number;
* [required](#required) - Validate a value to be not empty.

# Validator Strategy

`\Greg\Support\Validation\ValidatorStrategy` is a strategy for custom validators.

## method

Description.

```php
method(mixed ...$args): mixed
```

`...$args` - Arguments.

_Example:_

```php
\Greg\Support\Image::method(...$args);
```
