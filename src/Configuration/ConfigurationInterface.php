<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Configuration;

use ArrayAccess;
use Countable;
use Es\Container\Merging\MergingInterface;
use Es\Container\Property\PropertyInterface;
use Iterator;

/**
 * The interface of typical configuration object.
 */
interface ConfigurationInterface extends
    ArrayAccess,
    Countable,
    MergingInterface,
    PropertyInterface,
    Iterator
{
    /**
     * Resets the configuration object.
     */
    public function reset();

    /**
     * Whether the configuration object is empty?
     *
     * @return bool Returns true on success, false otherwise
     */
    public function isEmpty();

    /**
     * Gets the configuration variable.
     *
     * @param int|string $name    The variable name
     * @param mixed      $default The default value
     *
     * @return mixed Returns the value of variable if variable exists,
     *               $default otherwise
     */
    public function get($name, $default = null);
}
