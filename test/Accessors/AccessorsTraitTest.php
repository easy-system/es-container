<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Accessors;

use ReflectionProperty;

class AccessorsTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'AccessorsTraitTemplate.php';
    }

    public function testSetItem()
    {
        $container = new AccessorsTraitTemplate();
        $container->setItem('foo', 'bar');

        $reflection = new ReflectionProperty($container, 'container');
        $reflection->setAccessible(true);
        $data = $reflection->getValue($container);

        $this->assertArrayHasKey('foo', $data);
        $this->assertSame('bar', $data['foo']);
    }

    public function testGetItemReturnsValue()
    {
        $container = new AccessorsTraitTemplate();
        $container->setItem('foo', 'bar');
        $this->assertSame('bar', $container->getItem('foo'));
    }

    public function testGetItemReturnsDefault()
    {
        $container = new AccessorsTraitTemplate();
        $this->assertSame('bar', $container->getItem('foo', 'bar'));
    }

    public function testHasItemOnSuccess()
    {
        $container = new AccessorsTraitTemplate();
        $container->setItem('foo', 'bar');
        $this->assertTrue($container->hasItem('foo'));
    }

    public function testHasItemOnFailure()
    {
        $container = new AccessorsTraitTemplate();
        $this->assertFalse($container->hasItem('foo'));
    }
}
