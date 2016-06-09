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

use Es\Container\AbstractContainer;
use Es\Container\ArrayAccess\ArrayAccessTrait;
use Es\Container\Countable\CountableTrait;
use Es\Container\Iterator\IteratorTrait;
use Es\Container\Merging\MergingTrait;
use Es\Container\Property\PropertyTrait;

/**
 * The implementation of configuration object.
 */
class Configuration extends AbstractContainer implements ConfigurationInterface
{
    use ArrayAccessTrait,
        CountableTrait,
        IteratorTrait,
        MergingTrait,
        PropertyTrait;

    /**
     * Constructor.
     *
     * @param array $config The configuration as array for data container
     */
    public function __construct(array $config = [])
    {
        $this->container = $config;
    }

    /**
     * Gets the variable.
     *
     * @param int|string $name    The variable name
     * @param mixed      $default The default value
     *
     * @return mixed Returns the value of variable if variable exists,
     *               $default otherwise
     */
    public function get($name, $default = null)
    {
        if (isset($this->container[$name])) {
            return $this->container[$name];
        }

        return $default;
    }
}
