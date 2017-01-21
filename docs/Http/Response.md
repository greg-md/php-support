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
* [setContentType](#setcontenttype) - Set content type;
* [getContentType](#getcontenttype) - Get content type;
* [setDisposition](#setdisposition) - Set disposition;
* [getDisposition](#getdisposition) - Get disposition;
* [setFileName](#setfilename) - Set file name;
* [getFileName](#getfilename) - Get file name;
* [setCharset](#setcharset) - Set charset;
* [getCharset](#getcharset) - Get charset;
* [setLocation](#setlocation) - Set location;
* [getLocation](#getlocation) - Get location;
* [setCode](#setcode) - Set code;
* [getCode](#getcode) - Get code;
* [setContent](#setcontent) - Set content;
* [getContent](#getcontent) - Get content;
* [toString](#tostring) - Get string content;
* [send](#send) - Send response;
* [sendCode](#sendcode) - Send a code;
* [sendLocation](#sendlocation) - Send a location;
* [sendRefresh](#sendrefresh) - Send a refresh;
* [sendBack](#sendback) - Send a redirect back;
* [sendJson](#sendjson) - Send a json;
* [sendHtml](#sendhtml) - Send an html;
* [sendText](#sendtext) - Send a text;
* [sendImage](#sendtext) - Send an image;
* [sendJpeg](#sendjpeg) - Send a jpeg;
* [sendGif](#sendgif) - Send a gif;
* [sendPng](#sendpng) - Send a png;
* [sendContentType](#sendcontenttype) - Send content type;
* [sendDisposition](#senddisposition) - Send disposition;
* [flush](#flush) - Flush the output buffer;
* [isModifiedSince](#ismodifiedsince) - Determine if the request was modified.

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
