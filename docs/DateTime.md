# DateTime Documentation

`\Greg\Support\DateTime` is working with dates and times.

Extends: [`\DateTime`](http://php.net/manual/en/class.datetime.php).

# Methods:

* [yearInterval](#toCurrentYearInterval) - Get a string interval to current year;
* [transform](#transform) - Transform a time;
* [transformLocale](#transformLocale) - Transform a time, using locale;
* [timestamp](#toTimestamp) - Get timestamp of a time;
* [diffTime](#diffTime) - Compare two times;
* [dateTimeString](#dateTimeString) - Get date-time string of a time;
* [iso8601](#iso8601) - Get ISO8601 of a time;
* [dateString](#dateString) - Get date string of a time;
* [timeString](#timeString) - Get time string of a time;
* [year](#year) - Get year of a time;
* [month](#month) - Get month of a time;
* [day](#day) - Get day of a time;
* [untilNow](#untilNow) - Get time until now.

## method

Description.

```php
method(mixed ...$args): mixed
```

`...$args` - Arguments.

_Example:_

```php
\Greg\Support\DateTime::method(...$args);
```
