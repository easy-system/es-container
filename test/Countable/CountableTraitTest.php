<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Countable;

use Es\Container\Configuration\Configuration;

class CountableTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
        $array = [
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
        ];
        $config = new Configuration;
        $i = 0;
        foreach ($array as $key => $value) {
            $config[$key] = $value;
            $this->assertSame(++$i, count($config));
        }
    }
}
