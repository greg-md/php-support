# Greg PHP Support

[![StyleCI](https://styleci.io/repos/66374374/shield?style=flat)](https://styleci.io/repos/66374374)
[![Build Status](https://travis-ci.org/greg-md/php-support.svg)](https://travis-ci.org/greg-md/php-support)
[![Total Downloads](https://poser.pugx.org/greg-md/php-support/d/total.svg)](https://packagist.org/packages/greg-md/php-support)
[![Latest Stable Version](https://poser.pugx.org/greg-md/php-support/v/stable.svg)](https://packagist.org/packages/greg-md/php-support)
[![Latest Unstable Version](https://poser.pugx.org/greg-md/php-support/v/unstable.svg)](https://packagist.org/packages/greg-md/php-support)
[![License](https://poser.pugx.org/greg-md/php-support/license.svg)](https://packagist.org/packages/greg-md/php-support)

Support classes for PHP.

# Table of Contents:

* [Requirements](#requirements)
* [Documentation](#documentation)
* [License](#license)
* [Huuuge Quote](#huuuge-quote)

# Requirements

* PHP Version `^5.6 || ^7.0`

# Documentation

* [Str](docs/Str.md) - Working with strings;
* [Arr](docs/Arr.md) - Working with arrays;
* [Obj](docs/Obj.md) - Working with objects;
* [Url](docs/Url.md) - Working with URLs;
* [Dir](docs/Dir.md) - Working with directories;
* [File](docs/File.md) - Working with files;
* [Image](docs/Image.md) - Working with images;
* [Session](docs/Session.md) - Working with `$_SESSION`;
* [DateTime](docs/DateTime.md) - Working with dates and times;
* [Server](docs/Server.md) - Working with server configurations;
* [Config](docs/Config.md) - Working with config files;
* [Validation](docs/Validation.md) - Validate parameters against validators.
* **Accessor**
    * [AccessorTrait](docs/Accessor/AccessorTrait.md) - A trait for **private** usage of the storage in a class;
    * [AccessorStaticTrait](docs/Accessor/AccessorStaticTrait.md) - A trait for **private** usage of the storage in a static class;
    * [ArrayAccessorTrait](docs/Accessor/ArrayAccessorTrait.md) - A trait for **public** usage of an storage in a class;
    * [ArrayAccessorStaticTrait](docs/Accessor/ArrayAccessorStaticTrait.md) - A trait for **public** usage of an storage in a static class;
    * [ArrayAccessTrait](docs/Accessor/ArrayAccessTrait.md) - A trait for **public** usage of the storage in a class with [`\ArrayAccess`](http://php.net/manual/en/class.arrayaccess.php) support;
    * [ArrayAccessStaticTrait](docs/Accessor/ArrayAccessStaticTrait.md) - A trait for **public** usage of the storage in a static class;
    * [CountableTrait](docs/Accessor/CountableTrait.md) - A trait for [Countable](http://php.net/manual/en/class.countable.php) interface;
    * [IteratorAggregateTrait](docs/Accessor/IteratorAggregateTrait.md) - A trait for [IteratorAggregate](http://php.net/manual/en/class.iteratoraggregate.php) interface;
    * [SerializableTrait](docs/Accessor/SerializableTrait.md) - A trait for [Serializable](http://php.net/manual/en/class.serializable.php) interface;
    * [ArrayObject](docs/Accessor/ArrayObject.md) - Array as an object.
* **Http**
    * [Request](docs/Http/Request.md) - Working with `http request` in an object-oriented way;
    * [Response](docs/Http/Response.md) - Working with `http response` in an object-oriented way.
* **Tools**
    * [Html](docs/Tools/Html.md) - Working with html;
    * [Color](docs/Tools/Color.md) - Working with colors;
    * [Math](docs/Tools/Math.md) - Working with math;
    * [Regex](docs/Tools/Regex.md) - Working with regular expressions;
    * [InNamespaceRegex](docs/Tools/InNamespaceRegex.md) - Generate a regular expression to search in desired namespaces. Ex: `{{ Find Me! }}`;
    * [SubHtml](docs/Tools/SubHtml.md) - Extract a sub-html from a html.

# License

MIT © [Grigorii Duca](http://greg.md)

# Huuuge Quote

![I fear not the man who has practiced 10,000 programming languages once, but I fear the man who has practiced one programming language 10,000 times. #horrorsquad](http://greg.md/huuuge-quote-fb.jpg)
