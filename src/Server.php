<?php

namespace Greg\Support;

class Server
{
    public static function scriptName()
    {
        return static::get('SCRIPT_NAME');
    }

    public static function scriptFile()
    {
        return static::get('SCRIPT_FILENAME');
    }

    public static function requestTime()
    {
        return static::get('REQUEST_TIME');
    }

    public static function requestMicroTime()
    {
        return static::get('REQUEST_TIME_FLOAT');
    }

    public static function documentRoot()
    {
        return static::get('DOCUMENT_ROOT');
    }

    public static function has($key)
    {
        return Arr::has($_SERVER, $key);
    }

    public static function get($key, $else = null)
    {
        return Arr::get($_SERVER, $key, $else);
    }

    public static function encoding($encoding = null)
    {
        return mb_internal_encoding(...func_get_args());
    }

    public static function timezone($timezone = null)
    {
        return func_num_args() ? date_default_timezone_set($timezone) : date_default_timezone_get();
    }

    public static function iniAll($extension = null, $details = true)
    {
        return ini_get_all(...func_get_args());
    }

    public static function iniGet($var)
    {
        if (($value = ini_get($var)) === false) {
            throw new \Exception('Server option `' . $var . '` does not exists.');
        }

        return $value;
    }

    public static function iniSet($var, $value)
    {
        if (($oldValue = ini_set($var, $value)) === false) {
            throw new \Exception('Server option `' . $var . '` can not be set.');
        }

        return $oldValue;
    }

    public static function appendIncPath($path)
    {
        return static::addIncPath($path);
    }

    public static function prependIncPath($path)
    {
        return static::addIncPath($path, true);
    }

    public static function resetIncPath()
    {
        return set_include_path('.');
    }

    public static function existsInIncPaths($fileName)
    {
        return stream_resolve_include_path($fileName) !== false;
    }

    public static function errorsAsExceptions($exception = \Exception::class)
    {
        set_error_handler(function ($errNo, $errStr/*, $errFile, $errLine*/) use ($exception) {
            unset($errNo);

            throw new $exception($errStr);
        });

        return true;
    }

    public static function disableErrors()
    {
        set_error_handler(function ($errNo, $errStr, $errFile, $errLine) {
        });

        return true;
    }

    public static function restoreErrors()
    {
        return restore_error_handler();
    }

    public static function env($name)
    {
        if (array_key_exists($name, $_ENV)) {
            return $_ENV[$name];
        }

        if (array_key_exists($name, $_SERVER)) {
            return $_SERVER[$name];
        }

        $value = getenv($name);

        return $value === false ? null : $value;
    }

    public static function loadEnvironmentFile($file, $immutable = false)
    {
        foreach (File::lines($file) as $line) {
            if (!self::isComment($line) || self::looksLikeSetter($line)) {
                list($name, $value) = self::splitCompoundStringIntoParts($line);

                static::setEnvironmentVariable($name, $value, $immutable);
            }
        }

        return true;
    }

    public static function setEnvironmentVariable($name, $value, $immutable = false)
    {
        $name = self::sanitiseVariableName($name);

        $value = self::sanitiseVariableValue($value);

        $value = self::resolveNestedVariables($value);

        // Don't overwrite existing environment variables if we're immutable
        // Ruby's dotenv does this with `ENV[key] ||= value`.
        if ($immutable && self::getEnvironmentVariable($name) !== null) {
            return false;
        }

        // If PHP is running as an Apache module and an existing
        // Apache environment variable exists, overwrite it
        if (function_exists('apache_getenv') && function_exists('apache_setenv') && apache_getenv($name)) {
            apache_setenv($name, $value);
        }

        if (function_exists('putenv')) {
            putenv("$name=$value");
        }

        $_ENV[$name] = $value;

        $_SERVER[$name] = $value;

        return true;
    }

    public static function getEnvironmentVariable($name)
    {
        if (array_key_exists($name, $_ENV)) {
            return $_ENV[$name];
        }

        if (array_key_exists($name, $_SERVER)) {
            return $_SERVER[$name];
        }

        $value = getenv($name);

        return $value === false ? null : $value; // switch getenv default to null
    }

    private static function isComment($line)
    {
        $line = ltrim($line);

        return isset($line[0]) && $line[0] === '#';
    }

    private static function looksLikeSetter($line)
    {
        return strpos($line, '=') !== false;
    }

    private static function splitCompoundStringIntoParts($string)
    {
        if (strpos($string, '=') !== false) {
            return array_map('trim', explode('=', $string, 2));
        }

        return [$string, null];
    }

    private static function sanitiseVariableName($name)
    {
        return trim(str_replace(['export ', '\'', '"'], '', $name));
    }

    private static function sanitiseVariableValue($value)
    {
        if (!$value = trim($value)) {
            return $value;
        }

        if (self::beginsWithAQuote($value)) { // value starts with a quote
            $quote = $value[0];

            $regexPattern = sprintf(
                '/^
                %1$s          # match a quote at the start of the value
                (             # capturing sub-pattern used
                 (?:          # we do not need to capture this
                  [^%1$s\\\\] # any character other than a quote or backslash
                  |\\\\\\\\   # or two backslashes together
                  |\\\\%1$s   # or an escaped quote e.g \"
                 )*           # as many characters that match the previous rules
                )             # end of the capturing sub-pattern
                %1$s          # and the closing quote
                .*$           # and discard any string after the closing quote
                /mx',
                $quote
            );

            $value = preg_replace($regexPattern, '$1', $value);

            $value = str_replace("\\$quote", $quote, $value);

            $value = str_replace('\\\\', '\\', $value);
        } else {
            $parts = explode(' #', $value, 2);

            $value = trim($parts[0]);

            // Unquoted values cannot contain whitespace
            if (preg_match('/\s+/', $value) > 0) {
                throw new \Exception('Dotenv values containing spaces must be surrounded by quotes.');
            }
        }

        return trim($value);
    }

    private static function beginsWithAQuote($value)
    {
        return isset($value[0]) && ($value[0] === '"' || $value[0] === '\'');
    }

    private static function resolveNestedVariables($value)
    {
        if (strpos($value, '$') !== false) {
            $value = preg_replace_callback('/\${([a-zA-Z0-9_]+)}/', function ($matchedPatterns) {
                $nestedVariable = static::getEnvironmentVariable($matchedPatterns[1]);

                if ($nestedVariable === null) {
                    return $matchedPatterns[0];
                } else {
                    return $nestedVariable;
                }
            }, $value);
        }

        return $value;
    }

    private static function addIncPath($path, $prepend = false)
    {
        $path = (array) $path;

        $incPaths = explode(PATH_SEPARATOR, get_include_path());

        $path = array_values($path);

        $path = $prepend ? array_merge($path, $incPaths) : array_merge($incPaths, $path);

        $path = array_unique($path);

        $path = array_filter($path);

        return set_include_path(implode(PATH_SEPARATOR, $path));
    }
}
