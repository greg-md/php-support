# Http Response Documentation

`\Greg\Support\Http\Response` is working with `http response` in an object-oriented way.

Throws: `\Greg\Support\Http\ResponseException`.

# Constants

```php
const CODES = [
    100 => 'Continue',
    101 => 'Switching Protocols',
    102 => 'Processing',            // RFC2518
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    207 => 'Multi-Status',          // RFC4918
    208 => 'Already Reported',      // RFC5842
    226 => 'IM Used',               // RFC3229
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    306 => 'Reserved',
    307 => 'Temporary Redirect',
    308 => 'Permanent Redirect',    // RFC7238
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    418 => 'I\'m a teapot',                                               // RFC2324
    422 => 'Unprocessable Entity',                                        // RFC4918
    423 => 'Locked',                                                      // RFC4918
    424 => 'Failed Dependency',                                           // RFC4918
    425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
    426 => 'Upgrade Required',                                            // RFC2817
    428 => 'Precondition Required',                                       // RFC6585
    429 => 'Too Many Requests',                                           // RFC6585
    431 => 'Request Header Fields Too Large',                             // RFC6585
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
    507 => 'Insufficient Storage',                                        // RFC4918
    508 => 'Loop Detected',                                               // RFC5842
    510 => 'Not Extended',                                                // RFC2774
    511 => 'Network Authentication Required',                             // RFC6585
];
```

# Methods:

* [back](#back) - Set redirection back;
* [download](#download) - Set a download file;
* [inline](#inline) - Set an inline file;
* [json](#json) - Set a json content;
* [refresh](#refresh) - Set a refresh;
* [isHtml](#isHtml) - Determine if the response is a html response;
* [setContentType](#setContentType) - Set content type;
* [getContentType](#getContentType) - Get content type;
* [setDisposition](#setDisposition) - Set disposition;
* [getDisposition](#getDisposition) - Get disposition;
* [setFileName](#setFileName) - Set file name;
* [getFileName](#getFileName) - Get file name;
* [setCharset](#setCharset) - Set charset;
* [getCharset](#getCharset) - Get charset;
* [setLocation](#setLocation) - Set location;
* [getLocation](#getLocation) - Get location;
* [setCode](#setCode) - Set code;
* [getCode](#getCode) - Get code;
* [setContent](#setContent) - Set content;
* [getContent](#getContent) - Get content;
* [toString](#toString) - Get string content;
* [send](#send) - Send response;
* [sendCode](#sendCode) - Send a code;
* [sendLocation](#sendLocation) - Send a location;
* [sendRefresh](#sendRefresh) - Send a refresh;
* [sendBack](#sendBack) - Send a redirect back;
* [sendJson](#sendJson) - Send a json;
* [sendHtml](#sendHtml) - Send an html;
* [sendText](#sendText) - Send a text;
* [sendImage](#sendText) - Send an image;
* [sendJpeg](#sendJpeg) - Send a jpeg;
* [sendGif](#sendGif) - Send a gif;
* [sendPng](#sendPng) - Send a png;
* [sendContentType](#sendContentType) - Send content type;
* [sendDisposition](#sendDisposition) - Send disposition;
* [flush](#flush) - Flush the output buffer;
* [isModifiedSince](#isModifiedSince) - Determine if the request was modified;

**Magic methods**

* [__construct](#__construct) - Constructor;
* [__toString](#__toString) - Magic method. See [toString](#toString);

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
