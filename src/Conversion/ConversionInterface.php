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
 * Represents the abstraction of the import and export of the PHP
 * array in / from instance of data container.
 */
interface ConversionInterface
{
    /**
     * Returns a PHP array from the data container.
     *
     * @return array The array from container
     */
    public function toArray();

    /**
     * Import a PHP array to container.
     *
     * @param array $source The array to import
     *
     * @return self
     */
    public function fromArray(array $source = []);
}
