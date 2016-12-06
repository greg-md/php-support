<?php

namespace Greg\Support;

class Env
{
    /**
     * Detect the application's current environment.
     *
     * @param array|string $environments
     * @param array|null   $consoleArgs
     *
     * @return string
     */
    public static function detect($environments, $consoleArgs = null)
    {
        if ($consoleArgs) {
            return static::detectConsoleEnvironment($environments, $consoleArgs);
        }

        return static::detectWebEnvironment($environments);
    }

    /**
     * Set the application environment for a web request.
     *
     * @param array|string $environments
     *
     * @return string
     */
    protected static function detectWebEnvironment($environments)
    {
        // If the given environment is just a Closure, we will defer the environment check
        // to the Closure the developer has provided, which allows them to totally swap
        // the webs environment detection logic with their own custom Closure's code.
        if ($environments instanceof \Closure) {
            return call_user_func($environments);
        }

        foreach ($environments as $environment => $hosts) {
            $hosts = (array) $hosts;
            // To determine the current environment, we'll simply iterate through the possible
            // environments and look for the host that matches the host for this request we
            // are currently processing here, then return back these environment's names.
            foreach ($hosts as $host) {
                if (static::isMachine($host)) {
                    return $environment;
                }
            }
        }

        return 'production';
    }

    /**
     * Set the application environment from command-line arguments.
     *
     * @param mixed $environments
     * @param array $args
     *
     * @return string
     */
    protected static function detectConsoleEnvironment($environments, array $args)
    {
        // First we will check if an environment argument was passed via console arguments
        // and if it was that automatically overrides as the environment. Otherwise, we
        // will check the environment as a "web" request like a typical HTTP request.
        if (!is_null($value = static::getEnvironmentArgument($args))) {
            $parts = array_slice(explode('=', $value), 1);

            return Arr::first($parts);
        }

        return static::detectWebEnvironment($environments);
    }

    /**
     * Get the environment argument from the console.
     *
     * @param array $args
     *
     * @return string|null
     */
    protected static function getEnvironmentArgument(array $args)
    {
        return Arr::first($args, function ($value) {
            return Str::startsWith($value, '--env');
        });
    }

    /**
     * Determine if the name matches the machine name.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function isMachine($name)
    {
        return Str::is($name, gethostname());
    }
}
