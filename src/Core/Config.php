<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Core;

/**
 * Config class.
 *
 * Provides an object oriented way of accessing arrays.
 *
 * @author  Andreas Kollaros
 * @license MIT {@link http://opensource.org/licenses/mit-license.php}
 */
class Config implements \ArrayAccess, \Iterator
{

    /**
     * The array of option values.
     *
     * @var array
     */
    private $config = array();

    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->config);
    }

    /**
     * Returns an array from config.
     *
     * @access public
     * @return array
     */
    public function getArrayCopy()
    {
        return $this->config;
    }

    /* -(  Iterator  )------------------------------------------------------ */

    public function rewind()
    {
        reset($this->config);
    }

    public function current()
    {
        return current($this->config);
    }

    public function key()
    {
        return key($this->config);
    }

    public function next()
    {
        next($this->config);
    }

    public function valid()
    {
        return current($this->config) !== false;
    }

    /* -(  ArrayAccess  )--------------------------------------------------- */

    public function offsetSet($offset, $value)
    {
        return false;
    }

    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    public function offsetUnset($offset) {
        unset($this->config[$offset]);
    }

    public function offsetGet($offset)
    {
        $value = $this->__isset($offset)
            ? $this->config[$offset]
            : null;

        if (is_array($value)) {
            return new self($value);
        }

        return $value;
    }
}
