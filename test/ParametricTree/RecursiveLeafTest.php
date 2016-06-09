<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\ParametricTree;

use Es\Container\ParametricTree\RecursiveLeaf;
use ReflectionProperty;

class RecursiveLeafTest extends \PHPUnit_Framework_TestCase
{
    protected $iterator;

    protected $expected = [0, 1, 4, 6, 5, 2, 3];

    public function setUp()
    {
        $this->iterator = new RecursiveLeaf();
        $this->iterator->setUniqueKey(0);

        $first = new RecursiveLeaf();
        $first->setUniqueKey(1);
        $this->iterator->addChild($first);

        $second = new RecursiveLeaf();
        $second->setUniqueKey(2);
        $this->iterator->addChild($second);

        $third = new RecursiveLeaf();
        $third->setUniqueKey(3);
        $this->iterator->addChild($third);

        $fourth = new RecursiveLeaf();
        $fourth->setUniqueKey(4);
        $first->addChild($fourth);

        $sixth = new RecursiveLeaf();
        $sixth->setUniqueKey(6);
        $fourth->addChild($sixth);

        $fifth = new RecursiveLeaf();
        $fifth->setUniqueKey(5);
        $fourth->addChild($fifth);
    }

    public function testAddLeaf()
    {
        $leaf = new RecursiveLeaf();

        $child = $this->getMock(RecursiveLeaf::CLASS);
        $child
            ->expects($this->once())
            ->method('setDepth')
            ->with($this->identicalTo(1));

        $leaf->addChild($child);

        $reflection = new ReflectionProperty($leaf, 'children');
        $reflection->setAccessible(true);
        $children = $reflection->getValue($leaf);

        $this->assertContains($child, $children);
    }

    public function testSetUniqueKeyOnSuccess()
    {
        $leaf = new RecursiveLeaf();
        $leaf->setUniqueKey('foo');

        $reflection = new ReflectionProperty($leaf, 'uniqueKey');
        $reflection->setAccessible(true);

        $this->assertSame('foo', $reflection->getValue($leaf));
    }

    public function testSetUniqueKeyRaiseExceptionIfKeyWasAlreadySet()
    {
        $leaf = new RecursiveLeaf();
        $leaf->setUniqueKey('foo');

        $this->setExpectedException('RuntimeException');
        $leaf->setUniqueKey('bar');
    }

    public function invalidUniqueKeyDataProvider()
    {
        return [
            [null],
            [true],
            [false],
            [[]],
            [new \stdClass()],
        ];
    }

    /**
     * @dataProvider invalidUniqueKeyDataProvider
     */
    public function testSetUniqueKeyRaiseExceptionIfSpecifiedKeyHasInvalidType($key)
    {
        $leaf = new RecursiveLeaf();
        $this->setExpectedException('InvalidArgumentException');
        $leaf->setUniqueKey($key);
    }

    public function testGetUniqueKey()
    {
        $leaf = new RecursiveLeaf();
        $this->assertNull($leaf->getUniqueKey());

        $leaf->setUniqueKey('foo');
        $this->assertSame('foo', $leaf->getUniqueKey());
    }

    public function testSetDepthOnSuccess()
    {
        $leaf = new RecursiveLeaf();
        $leaf->setDepth(10);

        $reflection = new ReflectionProperty($leaf, 'depth');
        $reflection->setAccessible(true);

        $this->assertSame(10, $reflection->getValue($leaf));
    }

    public function testSetDepthRaiseExceptionIfDepthWasAlreadySet()
    {
        $leaf = new RecursiveLeaf();
        $leaf->setDepth(10);

        $this->setExpectedException('RuntimeException');
        $leaf->setDepth(1);
    }

    public function invalidDepthDataProvider()
    {
        return [
            [null],
            [true],
            [false],
            ['string'],
            [[]],
            [new \stdClass()],
        ];
    }

    /**
     * @dataProvider invalidDepthDataProvider
     */
    public function testSetDepthRaiseExceptionIfSpecifiedDepthHasInvalidType($depth)
    {
        $leaf = new RecursiveLeaf();
        $this->setExpectedException('InvalidArgumentException');
        $leaf->setDepth($depth);
    }

    public function testGetDepth()
    {
        $leaf = new RecursiveLeaf();
        $this->assertNull($leaf->getDepth());

        $leaf->setDepth(10);
        $this->assertSame(10, $leaf->getDepth());
    }

    public function testCount()
    {
        $leaf = new RecursiveLeaf();
        for ($i = 0; $i < 10; ++$i) {
            $child = new RecursiveLeaf();
            $leaf->addChild($child);
            $this->assertSame($i + 1, $leaf->count());
        }
    }

    public function testCurrent()
    {
        foreach ($this->expected as $uniqueKey) {
            $leaf = $this->iterator->current();
            $this->assertSame($uniqueKey, $leaf->getUniqueKey());
            $this->iterator->next();
        }

        $this->iterator->next();
        $this->assertFalse($this->iterator->current());
    }

    public function testKey()
    {
        foreach ($this->expected as $uniqueKey) {
            $this->assertSame($uniqueKey, $this->iterator->key());
            $this->iterator->next();
        }

        $this->iterator->next();
        $this->assertNull($this->iterator->key());
    }

    public function testValid()
    {
        for ($i = 0; $i < count($this->expected); ++$i) {
            $this->assertTrue($this->iterator->valid());
            $this->iterator->next();
        }
        $this->iterator->next();
        $this->assertFalse($this->iterator->valid());
    }

    public function testRewind()
    {
        for ($i = 0; $i < count($this->expected); ++$i) {
            $this->iterator->next();
        }
        $this->iterator->rewind();
        $firstLeaf = $this->iterator->current();
        $this->assertEquals(reset($this->expected), $firstLeaf->getUniqueKey());
    }

    public function testGetReturnsValueIfAny()
    {
        $leaf = new RecursiveLeaf();

        $leaf->foo = 'bar';
        $this->assertSame('bar', $leaf->get('foo'));
    }

    public function testGetReturnsDefault()
    {
        $leaf = new RecursiveLeaf();
        $this->assertSame('bar', $leaf->get('foo', 'bar'));
    }
}
