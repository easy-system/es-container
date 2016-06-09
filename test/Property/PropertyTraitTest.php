<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Property;

use Es\Container\Configuration\Configuration;
use ReflectionProperty;

class PropertyTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $array = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
            'baz' => 'baz_value',
        ];
        $config = new Configuration();
        foreach ($array as $key => $value) {
            $config->$key = $value;
        }
        $reflection = new ReflectionProperty($config, 'container');
        $reflection->setAccessible(true);
        $this->assertSame($array, $reflection->getValue($config));
    }

    public function testGet()
    {
        $config = new Configuration();
        $this->assertNull($config->missingVariable);
        //
        $config->foo = 'foo_value';
        $this->assertSame('foo_value', $config->foo);
    }

    public function testIsset()
    {
        $config = new Configuration();
        $this->assertFalse(isset($config->missingVariable));
        //
        $config->foo = 'foo_value';
        $this->assertTrue(isset($config->foo));
    }

    public function testOffsetUnset()
    {
        $config      = new Configuration();
        $config->foo = 'foo_value';
        $this->assertTrue(isset($config->foo));
        //
        unset($config->foo);
        $this->assertFalse(isset($config->foo));
    }
}
