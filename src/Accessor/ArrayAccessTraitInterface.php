<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

interface ArrayAccessTraitInterface extends \ArrayAccess
{
    public function has($key);

    public function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER);

    public function set($key, $value);

    public function setRef($key, &$value);

    public function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER);

    public function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER);

    public function get($key, $else = null);

    public function &getRef($key, &$else = null);

    public function getForce($key, $else = null);

    public function &getForceRef($key, &$else = null);

    public function getArray($key, $else = null);

    public function &getArrayRef($key, &$else = null);

    public function getArrayForce($key, $else = null);

    public function &getArrayForceRef($key, &$else = null);

    public function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public function del($key);

    public function delIndex($index, $delimiter = Arr::INDEX_DELIMITER);
}
