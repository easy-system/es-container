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

use Es\Container\Conversion\ConversionTrait;
use InvalidArgumentException;
use Traversable;

/**
 * Implementation of MergingInterface.
 */
trait MergingTrait
{
    use ConversionTrait;

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
    public function merge($source)
    {
        if ($source instanceof MergingInterface) {
            $source = $source->toArray();
        } elseif ($source instanceof Traversable) {
            $source = iterator_to_array($source);
        } elseif ($source instanceof \stdClass) {
            $source = (array) $source;
        } elseif (! is_array($source)) {
            throw new InvalidArgumentException(sprintf(
                'Failed to merge with source of type "%s".',
                is_object($source) ? get_class($source) : gettype($source)
            ));
        }
        $this->container = $this->arrayMerge($this->container, $source);
    }

    /**
     * Merge data from two arrays.
     *
     * @param array $target The target array
     * @param array $source The sourse array
     *
     * @return array The result of merging
     */
    protected function arrayMerge(array $target, array $source)
    {
        foreach ($source as $key => $value) {
            if ($value instanceof MergingInterface) {
                $value = $value->toArray();
            }
            if (isset($target[$key]) || array_key_exists($key, $target)) {
                if (is_int($key)) {
                    $target[] = $value;
                } elseif (is_array($value) && is_array($target[$key])) {
                    $target[$key] = $this->arrayMerge($target[$key], $value);
                } else {
                    $target[$key] = $value;
                }
            } else {
                $target[$key] = $value;
            }
        }

        return $target;
    }
}
