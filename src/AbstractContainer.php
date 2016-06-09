<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container;

/**
 * Represents an abstract container.
 */
abstract class AbstractContainer
{
    /**
     * The data container.
     *
     * @var array
     */
    protected $container = [];

    /**
     * Resets the container.
     */
    public function reset()
    {
        $this->container = [];
    }

    /**
     * Whether the container is empty?
     *
     * @return bool Returns true on success, false otherwise
     */
    public function isEmpty()
    {
        return empty($this->container);
    }
}
