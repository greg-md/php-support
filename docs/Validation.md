# Validation Documentation

`\Greg\Support\Validation\Validation` validate parameters against validators.

Throws: `\Greg\Support\Validation\ValidationException`.

# Table of contents:

* [Methods](#methods)
* [Validators](#validators)
* [Validator Strategy](#validator-strategy)

# Methods:

* [addValidators](#addvalidators) - Add validators;
* [addPrefix](#addprefix) - Add a prefix or an array of prefixes;
* [addSuffix](#addsuffix) - Add a suffix or an array of suffixes;
* [validate](#validate) - Validate parameters.

**Methods description is under construction.**

# Validators

* [dateTimeFrom](#datetimefrom) - Validate a `DateTime` to be grater than another `DateTime`;
* [dateTimeTo](#datetimeto) - Validate a `DateTime` to be less than another `DateTime`;
* [email](#email) - Validate an email address;
* [enum](#enum) - Validate a value to exists in a stack;
* [equal](#equal) - Validate a value to be equal with another value;
* [int](#int) - Validate a value to be an integer;
* [length](#length) - Validate a string length;
* [maxLength](#maxlength) - Validate a string maximum length;
* [minLength](#minlength) - Validate a string minimum length;
* [max](#max) - Validate a number to be less than another number;
* [min](#min) - Validate a number to be greater than another number;
* [required](#required) - Validate a value to be not empty.

# Validator Strategy

`\Greg\Support\Validation\ValidatorStrategy` is a strategy for custom validators.

_Example:_

```php
class CustomValidator implements \Greg\Support\Validation\ValidatorStrategy
{
    public function validate($value, array $values = [])
    {
        // @todo: validation strategy
    }
}
```

## validate

Validate a value.

```php
validate(mixed $value, array $values = []): boolean;
```

`$value` - The value;  
`$values` - Other values.
