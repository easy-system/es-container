<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Configuration;

use Es\Container\Configuration\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $array = [
            0     => 0,
            1     => 1,
            2     => 2,
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
        ];
        $config = new Configuration($array);
        $this->assertSame($array, $config->toArray());
    }

    public function testGetReturnsValueIfAny()
    {
        $config = new Configuration();
        $config['foo'] = 'bar';

        $this->assertSame('bar', $config->get('foo'));
    }

    public function testGetReturnsDefault()
    {
        $config = new Configuration();
        $this->assertSame('bar', $config->get('foo', 'bar'));
    }
}
