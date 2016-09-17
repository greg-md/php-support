<?php

namespace Greg\Support;

class Debug
{
    /**
     * @var \SplObjectStorage|null
     */
    protected static $parents = null;

    public static function fixInfo($object, $vars, $full = true)
    {
        if (!static::$parents) {
            static::$parents = new \SplObjectStorage();
        }

        static::$parents->attach($object);

        $return = [];

        $reflection = new \ReflectionClass($object);

        foreach ($reflection->getConstants() as $name => $value) {
            $return[$name . ':constant'] = $value;
        }

        $return = array_merge($return, static::fetchVars($object, $reflection->getStaticProperties(), $full));

        $return = array_merge($return, static::fetchVars($object, $vars, $full));

        if (static::$parents) {
            static::$parents->detach($object);

            if (!static::$parents->count()) {
                static::$parents = null;
            }
        }

        return $return;
    }

    public static function fetchVars($object, array $vars = [], $full = true)
    {
        $return = [];

        foreach ($vars as $name => $value) {
            $property = new \ReflectionProperty($object, $name);

            $key = [$name];

            $key[] = $property->isPrivate() ? 'private' : $property->isProtected() ? 'protected' : 'public';

            if ($property->isStatic()) {
                $key[] = 'static';
            }

            if (is_object($value)) {
                if (static::$parents and static::$parents->contains($value)) {
                    $value = get_class($value) . ' Object *RECURSIVE*';
                } elseif (!$full) {
                    $value = get_class($value) . ' Object';
                }
            }

            $return[implode(':', $key)] = $value;
        }

        return $return;
    }
}
