<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Converter;

/**
 * The interface of converter. Provides external data conversion between the
 * object and the native PHP array.
 */
interface ConverterInterface
{
    /**
     * Fills the object with specified data.
     *
     * @param object $object The object to fill
     * @param array  $data   The data to hydration
     *
     * @throws \InvalidArgumentException If specified object is not acceptable
     */
    public function fill($object, array $data);

    /**
     * Extracts data from object.
     *
     * @param object $object The object to extract
     *
     * @throws \InvalidArgumentException If specified object is not acceptable
     *
     * @return array
     */
    public function extract($object);
}
