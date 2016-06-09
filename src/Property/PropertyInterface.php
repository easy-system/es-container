<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Property;

/**
 * Represents the access to the dynamic properties of the container.
 */
interface PropertyInterface
{
    /**
     * Sets data to the dynamic properties of the container.
     *
     * @param string $name  The property name
     * @param mixed  $value The property value
     */
    public function __set($name, $value);

    /**
     * Gets data from the dynamic properties of the container.
     *
     * @param string $name The property name
     *
     * @return mixed The property value if exists, null otherwise
     */
    public function __get($name);

    /**
     * Wheter the dynamic properties exists.
     *
     * @param string $name The property name
     *
     * @return bool Returns true on success, false otherwise
     */
    public function __isset($name);

    /**
     * Unsets the dynamic properties of the container.
     *
     * @param string $name The property name
     */
    public function __unset($name);
}
