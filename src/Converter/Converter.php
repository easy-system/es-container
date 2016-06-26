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

use Es\Container\Conversion\ConversionInterface;
use InvalidArgumentException;

/**
 * Provides external data conversion between the object, that implements
 * \Es\Container\Conversion\ConversionInterface and the native PHP array.
 */
class Converter implements ConverterInterface
{
    /**
     * Fills the object with specified data.
     *
     * @param object $object The object to fill
     * @param array  $data   The data to hydration
     *
     * @throws \InvalidArgumentException If specified object not implements
     *                                   \Es\Container\Conversion\ConversionInterface
     */
    public function fill($object, array $data)
    {
        if (! $object instanceof ConversionInterface) {
            throw new InvalidArgumentException(sprintf(
                'Invalid object "%s" provided; must be an instance of "%s".',
                is_object($object) ? get_class($object) : gettype($object),
                ConversionInterface::CLASS
            ));
        }
        $object->fromArray($data);
    }

    /**
     * Extracts data from object.
     *
     * @param object $object The object to extract
     *
     * @throws \InvalidArgumentException If specified object not implements
     *                                   \Es\Container\Conversion\ConversionInterface
     *
     * @return array
     */
    public function extract($object)
    {
        if (! $object instanceof ConversionInterface) {
            throw new InvalidArgumentException(sprintf(
                'Invalid object "%s" provided; must be an instance of "%s".',
                is_object($object) ? get_class($object) : gettype($object),
                ConversionInterface::CLASS
            ));
        }

        return $object->toArray();
    }
}
