<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\ArrayAccess;

use Es\Container\Configuration\Configuration;
use ReflectionProperty;

class ArrayAccessTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testOffsetSet()
    {
        $array = [
            0     => 0,
            1     => 1,
            2     => 2,
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
        ];
        $config = new Configuration();
        foreach ($array as $key => $value) {
            $config[$key] = $value;
        }
        $reflection = new ReflectionProperty($config, 'container');
        $reflection->setAccessible(true);
        $this->assertEquals($array, $reflection->getValue($config));
    }

    public function testOffsetSetWithEmptyKey()
    {
        $config = new Configuration();

        $config[] = 'foo';
        $config[] = 'bar';

        $this->assertContains('foo', $config);
        $this->assertContains('bar', $config);
    }

    public function testOffsetGet()
    {
        $config = new Configuration();
        $this->assertNull($config['missing_variable']);

        $config['foo'] = 'foo_value';
        $this->assertSame('foo_value', $config['foo']);
    }

    public function testOffsetGetIndirectModification()
    {
        $config = new Configuration();

        $config['foo']['bar']['bat'] = 'baz';
        $this->assertSame('baz', $config['foo']['bar']['bat']);
        //
        $config['foo']['bar']['bat'] = 1;
        ++$config['foo']['bar']['bat'];
        $this->assertSame(2, $config['foo']['bar']['bat']);
    }

    public function testOffsetExists()
    {
        $config = new Configuration();

        $config['foo'] = 'foo_value';
        $this->assertArrayHasKey('foo', $config);
        $this->assertArrayNotHasKey('bar', $config);
    }

    public function testOffsetUnset()
    {
        $config = new Configuration();

        $config['foo'] = 'foo_value';
        $this->assertArrayHasKey('foo', $config);
        unset($config['foo']);
        $this->assertArrayNotHasKey('foo', $config);
    }
}
