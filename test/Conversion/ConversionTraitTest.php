<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Conversion;

use Es\Container\Configuration\Configuration;
use ReflectionProperty;

class ConversionTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $array = [
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
        ];
        $config = new Configuration();
        foreach ($array as $key => $value) {
            $config[$key] = $value;
        }
        $this->assertSame($array, $config->toArray());
    }

    public function testFromArray()
    {
        $array = [
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
        ];
        $config = new Configuration();
        $config->fromArray($array);
        $reflection = new ReflectionProperty($config, 'container');
        $reflection->setAccessible(true);
        $this->assertEquals($array, $reflection->getValue($config));
    }
}
