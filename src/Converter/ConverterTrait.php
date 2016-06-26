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
 * The trait of Converter.
 */
trait ConverterTrait
{
    /**
     * The converter.
     *
     * @var ConverterInterface
     */
    protected $converter;

    /**
     * Sets the converter.
     *
     * @param ConverterInterface $converter The converter
     */
    public function setConverter(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Gets the converter.
     *
     * @return ConverterInterface The converter
     */
    public function getConverter()
    {
        if (! $this->converter) {
            $this->converter = new Converter;
        }

        return $this->converter;
    }
}
