<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test;

use Es\Container\AbstractContainer;
use Es\Container\Configuration\Configuration;

class AbstractContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testContainer()
    {
        $this->assertTrue(property_exists(AbstractContainer::CLASS, 'container'));
    }

    public function testReset()
    {
        $container = new Configuration();

        $container['foo'] = 'bar';
        $this->assertTrue(isset($container['foo']));

        $return = $container->reset();
        $this->assertSame($return, $container);
        $this->assertFalse(isset($container['foo']));
    }

    public function testIsEmpty()
    {
        $container = new Configuration();
        $this->assertTrue($container->isEmpty());

        $container->foo = 'bar';
        $this->assertFalse($container->isEmpty());

        unset($container->foo);
        $this->assertTrue($container->isEmpty());

        $container['foo'] = 'bar';
        $this->assertFalse($container->isEmpty());

        unset($container['foo']);
        $this->assertTrue($container->isEmpty());
    }
}
