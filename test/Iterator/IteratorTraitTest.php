<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Iterator;

use Es\Container\Configuration\Configuration;

class IteratorTraitTest extends \PHPUnit_Framework_TestCase
{
    protected $array;

    protected $iterator;

    public function setUp()
    {
        $this->array = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
            'baz' => 'baz_value',
        ];

        $this->iterator = new Configuration;
        foreach ($this->array as $key => $value) {
            $this->iterator[$key] = $value;
        }
    }

    public function testCurrent()
    {
        foreach ($this->array as $item) {
            $this->assertSame($item, $this->iterator->current());
            $this->iterator->next();
        }
    }

    public function testKey()
    {
        foreach (array_keys($this->array) as $item) {
            $this->assertSame($item, $this->iterator->key());
            $this->iterator->next();
        }
    }

    public function testNext()
    {
        foreach ($this->array as $key => $value) {
            $this->assertSame($key, $this->iterator->key());
            $this->assertSame($value, $this->iterator->current());
            $this->iterator->next();
        }
    }

    public function testValid()
    {
        for ($i = 0; $i < count($this->array); $i++) {
            $this->assertTrue($this->iterator->valid());
            $this->iterator->next();
        }
        $this->iterator->next();
        $this->assertFalse($this->iterator->valid());
    }

    public function testRewind()
    {
        for ($i = 0; $i < count($this->array); $i++) {
            $this->iterator->next();
        }
        $this->iterator->rewind();
        $this->assertEquals(reset($this->array), $this->iterator->current());
    }
}
