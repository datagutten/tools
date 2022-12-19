<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */

/** @noinspection PhpLanguageLevelInspection */

namespace datagutten\tools;

use ArrayAccess;

class SimpleArrayAccess implements ArrayAccess
{
    public function offsetExists($offset): bool
    {
        return !empty($this->$offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
}