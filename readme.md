# Greg PHP Support

[![StyleCI](https://styleci.io/repos/66374374/shield?style=flat)](https://styleci.io/repos/66374374)
[![Build Status](https://travis-ci.org/greg-md/php-support.svg)](https://travis-ci.org/greg-md/php-support)
[![Total Downloads](https://poser.pugx.org/greg-md/php-support/d/total.svg)](https://packagist.org/packages/greg-md/php-support)
[![Latest Stable Version](https://poser.pugx.org/greg-md/php-support/v/stable.svg)](https://packagist.org/packages/greg-md/php-support)
[![Latest Unstable Version](https://poser.pugx.org/greg-md/php-support/v/unstable.svg)](https://packagist.org/packages/greg-md/php-support)
[![License](https://poser.pugx.org/greg-md/php-support/license.svg)](https://packagist.org/packages/greg-md/php-support)

Support classes for PHP

# Requirements

* PHP Version `^5.6 || ^7.0`

# Documentation

* [Str](docs/Str.md) - Working with strings;
* [Arr](docs/Arr.md) - Working with arrays;
* [Obj](docs/Obj.md) - Working with objects;
* [Url](docs/Url.md) - Working with URLs;
* [Dir](docs/DateTime.md) - Working with directories;
* [File](docs/File.md) - Working with files;
* [Image](docs/Image.md) - Working with images;
* [Html](docs/Html.md) - Working with html;
* [Session](docs/ServerIni.md) - Working with `$_SESSION`;
* [DateTime](docs/DateTime.md) - Working with dates and times;
* [Server](docs/Server.md) - Working with server configurations;
* [Config](docs/Config.md) - Working with config files.
* **Accessor**
    * [AccessorTrait](docs/AccessorTrait.md) - A trait for **private** usage of the storage in a class;
    * [AccessorStaticTrait](docs/AccessorStaticTrait.md) - A trait for **private** usage of the storage in a static class;
    * [ArrayAccessorTrait](docs/ArrayAccessorTrait.md) - A trait for **public** usage of an storage in a static class;
    * [ArrayAccessorStaticTrait](docs/ArrayAccessorStaticTrait.md) - A trait for **public** usage of an storage in a class;
    * [ArrayAccessTrait](docs/ArrayAccessTrait.md) - A trait for **public** usage of the storage in a class;
    * [ArrayAccessStaticTrait](docs/ArrayAccessStaticTrait.md) - A trait for **public** usage of the storage in a static class;
    * [CountableTrait](docs/CountableTrait.md) - A trait for [Countable](http://php.net/manual/en/class.countable.php) interface;
    * [IteratorAggregateTrait](docs/IteratorAggregateTrait.md) - A trait for [IteratorAggregate](http://php.net/manual/en/class.iteratoraggregate.php) interface;
    * [SerializableTrait](docs/SerializableTrait.md) - A trait for [Serializable](http://php.net/manual/en/class.serializable.php) interface;
    * [ArrayObject](docs/ArrayObject.md) - Array as an object.
* **Http**
    * [Request](docs/Request.md) - Working with `http request` in an object-oriented way;
    * [Response](docs/Response.md) - Working with `http response` in an object-oriented way.
* **Validation**
    * [Validation](docs/Validation.md) - Validate parameters against validators;
    * [ValidatorStrategy](docs/ValidatorStrategy.md) - A strategy for validators.
* **Validators**
    * [DateTimeFromValidator](docs/DateTimeFromValidator.md) - Validate a `DateTime` to be grater than another `DateTime`;
    * [DateTimeToValidator](docs/DateTimeToValidator.md) - Validate a `DateTime` to be less than another `DateTime`;
    * [EmailValidator](docs/EmailValidator.md) - Validate an email address;
    * [EnumValidator](docs/EnumValidator.md) - Validate a value to exists in a stack;
    * [EqualValidator](docs/EqualValidator.md) - Validate a value to be equal with another value;
    * [IntValidator](docs/IntValidator.md) - Validate a value to be an integer;
    * [LengthValidator](docs/LengthValidator.md) - Validate a string length;
    * [MaxLengthValidator](docs/LengthValidator.md) - Validate a string maximum length;
    * [MinLengthValidator](docs/MinLengthValidator.md) - Validate a string minimum length;
    * [MaxValidator](docs/MaxValidator.md) - Validate a number to be less than another number;
    * [MinValidator](docs/MinValidator.md) - Validate a number to be greater than another number;
    * [RequiredValidator](docs/RequiredValidator.md) - Validate a value to be not empty.
* **Tools**
    * [Color](docs/Color.md) - Some color tools;
    * [Math](docs/Math.md) - Some math tools;
    * [Regex](docs/Regex.md) - Some regular expression tools.
    * [InNamespaceRegex](docs/InNamespaceRegex.md) - Generate a regular expression to search in desired namespaces. Ex: `{{ Find Me! }}`.
    * [SubHtml](docs/SubHtml.md) - Extract a substring from a html with all needed tags.
