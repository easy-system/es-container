<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Conversion;

/**
 * Implementation of ConversionInterface.
 */
trait ConversionTrait
{
    /**
     * Returns a PHP array from the data container.
     *
     * @return array The array from container
     */
    public function toArray()
    {
        return $this->container;
    }

    /**
     * Import a PHP array to container.
     *
     * @param array $source The array to import
     *
     * @return self
     */
    public function fromArray(array $source = [])
    {
        $this->container = array_merge($this->container, $source);

        return $this;
    }
}
