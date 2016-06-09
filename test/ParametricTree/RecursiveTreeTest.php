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

use Es\Container\ParametricTree\RecursiveLeaf;
use Es\Container\ParametricTree\RecursiveLeafInterface;
use Es\Container\ParametricTree\RecursiveTree;

class RecursiveTreeTest extends \PHPUnit_Framework_TestCase
{
    protected $iterator;

    protected $expected = [0, 1, 2, 4, 6, 3, 5, 7];

    public function setUp()
    {
        $config = [
            [0, 0],
            [1, 0],
            [2, 1],
            [3, 1],
            [4, 2],
            [6, 2],
            [5, 3],
            [7, 3],
        ];
        $this->iterator = new RecursiveTree();
        foreach ($config as $item) {
            $this->iterator->buildLeaf($item[0], $item[1]);
        }
    }

    /**
     * This test is adapted for selection from the database.
     * Use something like this:
     * <pre>
     *     SELECT * FROM sometable ORDER BY parent_id, id
     * </pre>.
     */
    public function testGeneralTreeTest()
    {
        $config = [
            ['key' => 1, 'parent' => 0],
            ['key' => 2, 'parent' => 0],
            ['key' => 3, 'parent' => 0],
            ['key' => 4, 'parent' => 1],
            ['key' => 5, 'parent' => 1],
            ['key' => 8, 'parent' => 2],
            ['key' => 6, 'parent' => 5],
            ['key' => 7, 'parent' => 5],
        ];

        $tree = new RecursiveTree();

        foreach ($config as $item) {
            $leaf = $tree->buildLeaf($item['key'], $item['parent']);
            $leaf->fromArray($item);
        }

        $string = '';
        foreach ($tree as $item) {
            $string .= $item->get('key');
        }
        $expected = '14567283';
        $this->assertSame($expected, $string);
    }

    public function testSetPrototype()
    {
        $tree = new RecursiveTree();
        $leaf = new RecursiveLeaf();

        $tree->setLeafPrototype($leaf);
        $this->assertSame($leaf, $tree->getLeafPrototype());
    }

    public function testGetPrototype()
    {
        $tree = new RecursiveTree();
        $this->assertInstanceOf(RecursiveLeafInterface::CLASS, $tree->getLeafPrototype());
    }

    public function testBuildLeafBuildsLeafWithoutName()
    {
        $tree = new RecursiveTree();
        $leaf = $tree->buildLeaf();
        $this->assertInstanceOf(RecursiveLeafInterface::CLASS, $leaf);
    }

    public function testBuildLeafBuildsLeaf()
    {
        $tree = new RecursiveTree();

        $foo = $tree->buildLeaf('foo');
        $this->assertInstanceOf(RecursiveLeafInterface::CLASS, $foo);
        $this->assertSame('foo', $foo->getUniqueKey());
        $this->assertSame(0, $foo->getDepth());

        $bar = $tree->buildLeaf('bar', 'foo');
        $this->assertInstanceOf(RecursiveLeafInterface::CLASS, $bar);
        $this->assertSame('bar', $bar->getUniqueKey());
        $this->assertSame(1, $bar->getDepth());

        $this->assertSame(1, count($foo));
    }

    public function testBuildLeafRaiseExceptionIfTheLeafWithSpecifiedKeyAlreadyExists()
    {
        $tree = new RecursiveTree();
        $tree->buildLeaf('foo');

        $this->setExpectedException('InvalidArgumentException');
        $tree->buildLeaf('foo');
    }

    public function testBuildLeafRaiseExceptionIfTheSpecifiedParentLeafNotExists()
    {
        $tree = new RecursiveTree();

        $this->setExpectedException('InvalidArgumentException');
        $tree->buildLeaf('foo', 'bar');
    }

    public function testHasLeaf()
    {
        $tree = new RecursiveTree();
        $tree->buildLeaf('foo');

        $this->assertTrue($tree->hasLeaf('foo'));
        $this->assertFalse($tree->hasLeaf('bar'));
    }

    public function testGetLeafReturnsSpecifiedLeaf()
    {
        $tree = new RecursiveTree();
        $foo  = $tree->buildLeaf('foo');

        $this->assertSame($foo, $tree->getLeaf('foo'));
    }

    public function testGetLeafRaiseExceptionIfSpecifiedLeafNotExists()
    {
        $tree = new RecursiveTree();

        $this->setExpectedException('InvalidArgumentException');
        $tree->getLeaf('foo');
    }

    public function testSize()
    {
        $tree = new RecursiveTree();

        $config = [
            ['key' => 'foo', 'parent' => null],
            ['key' => 'bar', 'parent' => null],
            ['key' => 'bat', 'parent' => 'foo'],
            ['key' => 'baz', 'parent' => 'bar'],
        ];

        $count = 0;
        foreach ($config as $item) {
            ++$count;
            $tree->buildLeaf($item['key'], $item['parent']);
            $this->assertSame($count, $tree->getSize());
        }
    }

    public function testCount()
    {
        $tree = new RecursiveTree();

        $config = [
            ['key' => 'foo', 'parent' => null],
            ['key' => 'bar', 'parent' => null],
            ['key' => 'bat', 'parent' => 'foo'],
            ['key' => 'baz', 'parent' => 'bar'],
        ];

        $count = 0;
        foreach ($config as $item) {
            if (! $item['parent']) {
                ++$count;
            }
            $tree->buildLeaf($item['key'], $item['parent']);
            $this->assertSame($count, $tree->count());
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

    public function testNextRaiseExceptionIfUnexpectedLeafFound()
    {
        $config = [
            ['foo', null],
            ['bar', null],
            ['bat', 'foo'],
        ];
        $tree = new RecursiveTree();
        foreach ($config as $item) {
            $tree->buildLeaf($item[0], $item[1]);
        }

        $unexpectedLeaf = new RecursiveLeaf();
        $bar            = $tree->getLeaf('bar');
        $bar->addChild($unexpectedLeaf);

        $this->setExpectedException('UnexpectedValueException');
        foreach ($tree as $leaf) {
        }
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

    public function testValidIfTreeIsEmpty()
    {
        $tree = new RecursiveTree;
        $this->assertFalse($tree->valid());
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
}
