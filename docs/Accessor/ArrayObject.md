# ArrayObject Documentation

`\Greg\Support\Accessor\ArrayObject` is an array as an object.

# Methods:

* [__construct](#__construct) - Constructor;
* [toArray](#toArray) - Transform to array;
* [exchange](#exchange) - Exchange array;
* [exchangeRef](#exchangeRef) - Exchange array reference;
* [append](#append) - Append a value;
* [appendRef](#appendRef) - Append a value reference;
* [appendKey](#appendKey) - Append a key-value;
* [appendKeyRef](#appendKeyRef) - Append a key-value reference;
* [prependRef](#prependRef) - Prepend a value reference;
* [prependKey](#prependKey) - Prepend a key-value;
* [prependKeyRef](#prependKeyRef) - Prepend a key-value reference;
* [asort](#asort) - Asort array;
* [ksort](#ksort) - Ksort array;
* [natcasesort](#natcasesort) - Natcasesort array;
* [natsort](#natsort) - Natsort array;
* [uasort](#uasort) - Uasort array;
* [uksort](#uksort) - Uksort array;
* [current](#current) - Get current value;
* [key](#key) - Get current key;
* [next](#next) - Get next value;
* [reset](#reset) - Reset array;
* [first](#first) - Get first value;
* [last](#last) - Get last value;
* [clear](#clear) - Clear array;
* [inArray](#inArray) - Determine if a key is in array;
* [in](#in) - Determine if a value is in array;
* [merge](#merge) - Merge with an array;
* [mergeRecursive](#mergeRecursive) - Merge with an array recursively;
* [mergePrepend](#mergePrepend) - Merge prepend with an array recursively;
* [mergePrependRecursive](#mergePrependRecursive) - Merge prepend with an array recursively;
* [mergeValues](#mergeValues) - Merge values;
* [replace](#replace) - Replace with an array;
* [replaceRecursive](#replaceRecursive) - Replace with an array recursively;
* [replacePrepend](#replacePrepend) - Replace prepend with an array;
* [replacePrependRecursive](#replacePrependRecursive) - Replace prepend with an array recursively;
* [replaceValues](#replaceValues) - Replace values;
* [diff](#diff) - Diff array;
* [map](#map) - Map array;
* [mapRecursive](#mapRecursive) - Map array recursively;
* [filter](#filter) - Filter array;
* [filterRecursive](#filterRecursive) - Filter array recursively;
* [reverse](#reverse) - Reverse array;
* [chunk](#chunk) - Chunk array;
* [implode](#implode) - Implode array;
* [join](#implode) - Alias of [implode](#implode);
* [shift](#implode) - Shift array;
* [pop](#pop) - Pop array;
* [group](#group) - Group array;
* [column](#column) - Get column of arrays;
* [walk](#walk) - Walk array;
* [shuffle](#shuffle) - Shuffle array;
* [sort](#sort) - Sort array;
* [arsort](#arsort) - Arsort array;
* [krsort](#krsort) - Krsort array;
* [keys](#keys) - Get keys of array;
* [values](#values) - Get values of array.

## method

Description.

```php
method(mixed ...$args): mixed
```

`...$args` - Arguments.

_Example:_

```php
\Greg\Support\Server::method(...$args);
```
