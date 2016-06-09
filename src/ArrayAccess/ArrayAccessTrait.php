<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\ArrayAccess;

/**
 * Implementation of \ArrayAccess interface.
 */
trait ArrayAccessTrait
{
    /**
     * Whether an offset exists.
     *
     * @param mixed $offset The offset to check
     *
     * @return bool Returns true on success, false otherwise
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets the value at specified offset.
     *
     * @param mixed $offset The offset to retrieve
     *
     * @return mixed The value at specified offset if exists; null otherwise
     */
    public function &offsetGet($offset)
    {
        if (! isset($this->container[$offset])) {
            $this->container[$offset] = null;
        }

        return $this->container[$offset];
    }

    /**
     * Sets a value to the specified offset.
     *
     * @param mixed $offset The offset to set the value
     * @param mixed $value  The value to set
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->container[] = $value;

            return;
        }
        $this->container[$offset] = $value;
    }

    /**
     * Unsets a value to the specified offset.
     *
     * @param mixed $offset The offset to unset
     */
    public function offsetUnset($offset)
    {
        if (isset($this->container[$offset])) {
            unset($this->container[$offset]);
        }
    }
}
