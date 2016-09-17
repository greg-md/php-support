<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;

/**
 * Interface RequestStaticTraitInterface
 * @package Greg\Support\Http
 *
 * $_GET Methods
 *
 * @method static bool hasGetParams()
 * @method static bool hasGet($key)
 * @method static bool hasIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllGet()
 * @method static string getGet($key, $else = null)
 * @method static string getGetRef($key, &$else = null)
 * @method static string getForceGet($key, $else = null)
 * @method static string getForceGetRef($key, &$else = null)
 * @method static string getArrayGet($key, $else = null)
 * @method static string getArrayGetRef($key, &$else = null)
 * @method static string getArrayForceGet($key, $else = null)
 * @method static string getArrayForceGetRef($key, &$else = null)
 * @method static string getIndexGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_POST Methods
 *
 * @method static bool hasPostParams()
 * @method static bool hasPost($key)
 * @method static bool hasIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllPost()
 * @method static string getPost($key, $else = null)
 * @method static string getPostRef($key, &$else = null)
 * @method static string getForcePost($key, $else = null)
 * @method static string getForcePostRef($key, &$else = null)
 * @method static string getArrayPost($key, $else = null)
 * @method static string getArrayPostRef($key, &$else = null)
 * @method static string getArrayForcePost($key, $else = null)
 * @method static string getArrayForcePostRef($key, &$else = null)
 * @method static string getIndexPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_REQUEST Methods
 *
 * @method static bool hasRequestParams()
 * @method static bool hasRequest($key)
 * @method static bool hasIndexRequest($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllRequest()
 * @method static string getRequest($key, $else = null)
 * @method static string getRequestRef($key, &$else = null)
 * @method static string getForceRequest($key, $else = null)
 * @method static string getForceRequestRef($key, &$else = null)
 * @method static string getArrayRequest($key, $else = null)
 * @method static string getArrayRequestRef($key, &$else = null)
 * @method static string getArrayForceRequest($key, $else = null)
 * @method static string getArrayForceRequestRef($key, &$else = null)
 * @method static string getIndexRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_FILES Methods
 *
 * @method static bool hasFilesParams()
 * @method static bool hasFiles($key)
 * @method static bool hasIndexFiles($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllFiles()
 * @method static string getFiles($key, $else = null)
 * @method static string getFilesRef($key, &$else = null)
 * @method static string getForceFiles($key, $else = null)
 * @method static string getForceFilesRef($key, &$else = null)
 * @method static string getArrayFiles($key, $else = null)
 * @method static string getArrayFilesRef($key, &$else = null)
 * @method static string getArrayForceFiles($key, $else = null)
 * @method static string getArrayForceFilesRef($key, &$else = null)
 * @method static string getIndexFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 */
interface RequestStaticTraitInterface
{
    public static function protocol();

    public static function clientHost();

    public static function serverHost();

    public static function serverAdmin();

    public static function secured();

    public static function isSecured();

    public static function with();

    public static function port();

    public static function agent();

    public static function ip();

    public static function uri();

    public static function baseUri();

    public static function uriPath();

    public static function uriQuery();

    public static function relativeUri();

    public static function relativeUriPath();

    public static function relativeUriQuery();

    public static function referrer();

    public static function modifiedSince();

    public static function match();

    public static function time();

    public static function microTime();

    public static function ajax();

    public static function header($header);
}