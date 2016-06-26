<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Converter;

use Es\Container\Configuration\Configuration;
use Es\Container\Converter\Converter;

class ConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testFillSetsDataToContainer()
    {
        $container = $this->getMock(Configuration::CLASS, ['fromArray']);
        $converter = new Converter();

        $data = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $container
            ->expects($this->once())
            ->method('fromArray')
            ->with($this->identicalTo($data));

        $converter->fill($container, $data);
    }

    public function testExtractGetsDataFromContainer()
    {
        $container = $this->getMock(Configuration::CLASS, ['toArray']);
        $converter = new Converter();

        $data = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $container
            ->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue($data));

        $this->assertSame($data, $converter->extract($container));
    }

    public function invalidObjectDataProvider()
    {
        return [
            [null],
            [true],
            [false],
            [100],
            ['string'],
            [new \stdClass()],
        ];
    }

    /**
     * @dataProvider invalidObjectDataProvider
     */
    public function testFillRaiseExceptionIfInvalidObjectProvided($object)
    {
        $data      = ['foo' => 'bar'];
        $converter = new Converter();
        $this->setExpectedException('InvalidArgumentException');
        $converter->fill($object, $data);
    }

    /**
     * @dataProvider invalidObjectDataProvider
     */
    public function testExtractRaiseExceptionIfInvalidObjectProvided($object)
    {
        $converter = new Converter();
        $this->setExpectedException('InvalidArgumentException');
        $data = $converter->extract($object);
    }
}
