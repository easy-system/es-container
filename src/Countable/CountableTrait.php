<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Countable;

/**
 * Implementation of \Countable interface.
 */
trait CountableTrait
{
    /**
     * Count elements of data container.
     *
     * @return int Count of elements
     */
    public function count()
    {
        return count($this->container);
    }
}
