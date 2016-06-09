<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Merging;

use ArrayObject;
use Es\Container\Configuration\Configuration;

class MergingImplementationTest extends \PHPUnit_Framework_TestCase
{
    public function testMergeTwoArray()
    {
        $arrayFirst = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
        ];
        $arraySecond = [
            'bat' => 'bat_value',
            'baz' => 'baz_value',
        ];
        $expected = array_merge($arrayFirst, $arraySecond);
        $config   = new Configuration();
        $config->fromArray($arrayFirst);
        //
        $config->merge($arraySecond);
        $this->assertSame($expected, $config->toArray());
    }

    public function testMergeOverwriteStringKey()
    {
        $arrayFirst = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
        ];
        $arraySecond = [
            'foo' => 'new_foo_value',
            'baz' => 'baz_value',
        ];
        $expected = [
            'foo' => 'new_foo_value',
            'bar' => 'bar_value',
            'baz' => 'baz_value',
        ];
        $config = new Configuration();
        $config->fromArray($arrayFirst);
        //
        $config->merge($arraySecond);
        $this->assertSame($expected, $config->toArray());
    }

    public function testMergeAddIntegerKey()
    {
        $arrayFirst = [
            0     => 'first_value_of_integer_key',
            'foo' => 'foo_value',
        ];
        $arraySecond = [
            0     => 'second_value_of_integer_key',
            'baz' => 'baz_value',
        ];
        $expected = [
            0     => 'first_value_of_integer_key',
            'foo' => 'foo_value',
            1     => 'second_value_of_integer_key',
            'baz' => 'baz_value',
        ];
        $config = new Configuration();
        $config->fromArray($arrayFirst);
        //
        $config->merge($arraySecond);
        $this->assertSame($expected, $config->toArray());
    }

    public function testMergePassMergingImplementation()
    {
        $arrayFirst = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
        ];
        $arraySecond = [
            'bat' => 'bat_value',
            'baz' => 'baz_value',
        ];
        $expected = array_merge($arrayFirst, $arraySecond);
        //
        $firstConfiguration = new Configuration();
        $firstConfiguration->fromArray($arrayFirst);
        $secondConfiguration = new Configuration();
        $secondConfiguration->fromArray($arraySecond);
        //
        $firstConfiguration->merge($secondConfiguration);
        $this->assertSame($expected, $firstConfiguration->toArray());
    }

    public function testMergePassTraversable()
    {
        $arrayFirst = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
        ];
        $arraySecond = [
            'bat' => 'bat_value',
            'baz' => 'baz_value',
        ];
        $expected = array_merge($arrayFirst, $arraySecond);
        //
        $firstConfiguration = new Configuration();
        $firstConfiguration->fromArray($arrayFirst);
        $secondConfiguration = new ArrayObject($arraySecond);
        //
        $firstConfiguration->merge($secondConfiguration);
        $this->assertSame($expected, $firstConfiguration->toArray());
    }

    public function testMergePassStdClass()
    {
        $arrayFirst = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
        ];
        $arraySecond = [
            'bat' => 'bat_value',
            'baz' => 'baz_value',
        ];
        $expected = array_merge($arrayFirst, $arraySecond);
        //
        $firstConfiguration = new Configuration();
        $firstConfiguration->fromArray($arrayFirst);
        $secondConfiguration = (object) $arraySecond;
        //
        $firstConfiguration->merge($secondConfiguration);
        $this->assertSame($expected, $firstConfiguration->toArray());
    }

    public function testMergePassSomethingElse()
    {
        $config = new Configuration();
        $this->setExpectedException('\InvalidArgumentException');
        $config->merge(new self());
    }

    public function testMergeConvertMergingInterfaceImplementationToArray()
    {
        $arrayFirst = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
        ];
        $arraySecond = [
            'bat' => 'bat_value',
            'baz' => new Configuration([0 => 'baz_config']),
        ];
        $expected = [
            'foo' => 'foo_value',
            'bar' => 'bar_value',
            'bat' => 'bat_value',
            'baz' => ['0' => 'baz_config'],
        ];
        $config = new Configuration();
        $config->fromArray($arrayFirst);
        //
        $config->merge($arraySecond);
        $this->assertSame($expected, $config->toArray());
    }

    public function testMergeMergingTwoNestedArrays()
    {
        $arrayFirst = [
            'foo' => [
                'bar' => [
                    'baz' => 100,
                    300,
                ],
            ],
        ];
        $arraySecond = [
            'foo' => [
                'bar' => [
                    'baz' => 200,
                    400,
                ],
            ],
        ];
        $expected = [
            'foo' => [
                'bar' => [
                    'baz' => 200,
                    300,
                    400,
                ],
            ],
        ];
        $config = new Configuration();
        $config->fromArray($arrayFirst);
        //
        $config->merge($arraySecond);
        $this->assertSame($expected, $config->toArray());
    }
}
