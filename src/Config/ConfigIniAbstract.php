<?php

namespace Greg\Support\Config;

use Greg\Support\Storage\AccessorTrait;
use Greg\Support\Storage\ArrayAccessTrait;
use Greg\Support\Arr;

abstract class ConfigIniAbstract implements \ArrayAccess
{
    use AccessorTrait, ArrayAccessTrait;

    public function setContents(array $contents = [], $section = null, $indexDelimiter = null)
    {
        $this->setStorage(static::fetchContents($contents, $section, $indexDelimiter));

        return $this;
    }

    static protected function fetchContents($contents, $section = null, $indexDelimiter = null)
    {
        $return = [];

        if ($contents) {
            if ($section) {
                $partsParam = [];

                foreach ($contents as $key => $value) {
                    $parts = array_map('trim', explode(':', $key));

                    $partsParam[$key] = $parts;

                    $primary = array_shift($parts);

                    $return[$primary] = $indexDelimiter ? static::fetchIndexes($value, $indexDelimiter) : $value;
                }

                foreach ($partsParam as $parts) {
                    $primary = array_shift($parts);

                    foreach ($parts as $part) {
                        $return[$primary] = array_replace_recursive($return[$part], $return[$primary]);
                    }
                }
            } else {
                $return = $indexDelimiter ? static::fetchIndexes($contents, $indexDelimiter) : $contents;
            }

            if ($section) {
                if (!array_key_exists($section, $return)) {
                    throw new \Exception('Config ini section `' . $section . '` not found.');
                }

                $return = $return[$section];
            }
        }

        return $return;
    }

    static protected function fetchIndexes($contents, $indexDelimiter = Arr::INDEX_DELIMITER)
    {
        $fetchedSection = [];
        foreach ($contents as $key => $value) {
            $keys = explode($indexDelimiter, $key);

            $contentsLevel = &$fetchedSection;

            foreach ($keys as $part) {
                if ($part == '') {
                    $contentsLevel = &$contentsLevel[];
                } else {
                    $contentsLevel = &$contentsLevel[$part];
                }
            }

            if (is_array($value)) {
                $value = static::fetchIndexes($value, $indexDelimiter);
            }

            $contentsLevel = $value;
        }

        return $fetchedSection;
    }

    public function toArray()
    {
        return $this->getStorage();
    }
}