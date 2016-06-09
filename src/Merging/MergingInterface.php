<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Merging;

use Es\Container\Conversion\ConversionInterface;

/**
 * Representation of merging the data from other data sources.
 */
interface MergingInterface extends ConversionInterface
{
    /**
     * Merges data from other data sources.
     *
     * Any available data source will be converted into an array.
     * The values, that have an string keys, will be overwritten.
     * The values, that have an integer keys, will be added.
     * Any object that presents in the data source and implements the
     * MergingInterface, will be converted into array.
     *
     * @param array|MergingInterface|\Traversable|\stdClass $source The data
     *                                                              source
     *
     * @throws \InvalidArgumentException If the data source type is not
     *                                   compatible
     */
    public function merge($source);
}
