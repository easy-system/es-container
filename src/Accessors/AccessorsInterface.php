<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Accessors;

/**
 * Representation of container accessors.
 */
interface AccessorsInterface
{
    /**
     * Sets the item value.
     *
     * @param int|string $key  The key of item
     * @param mixed      $item The item value
     *
     * @return self
     */
    public function setItem($key, $item);

    /**
     * Gets the item value.
     *
     * @param int|string $key     The key of item
     * @param mixed      $default Optional; null by default. The default value
     *
     * @return mixed Returns the item value, if any, $default otherwise
     */
    public function getItem($key, $default = null);

    /**
     * Has there a specific item?
     *
     * @param int|string $key The key of item
     *
     * @return bool Returns true on success, false otherwise
     */
    public function hasItem($key);
}