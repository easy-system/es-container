<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Iterator;

/**
 * Implementation of \Iterator interface.
 */
trait IteratorTrait
{
    /**
     * Returns the current element.
     *
     * @return mixed The current element
     */
    public function current()
    {
        return current($this->container);
    }

    /**
     * Returns the key of the current element.
     *
     * @return scalar The key of the current element
     */
    public function key()
    {
        return key($this->container);
    }

    /**
     * Move forward to next element.
     */
    public function next()
    {
        next($this->container);
    }

    /**
     * Rewinds the Iterator to the first element.
     */
    public function rewind()
    {
        reset($this->container);
    }

    /**
     * Checks if current position is valid.
     *
     * @return bool Returns true on success, false otherwise
     */
    public function valid()
    {
        return ! is_null(key($this->container));
    }
}
