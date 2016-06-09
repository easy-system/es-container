<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Parameters;

use ReflectionProperty;

class ParametersTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'ParametersTemplate.php';
    }

    public function testSetParamsSetsParams()
    {
        $params = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $object = new ParametersTemplate();
        $object->setParams($params);

        $reflection = new ReflectionProperty($object, 'parameters');
        $reflection->setAccessible(true);
        $this->assertSame($params, $reflection->getValue($object));
    }

    public function testSetParamsReplaceParams()
    {
        $firstParams = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $secondParams = [
            'cor' => 'con',
            'con' => 'com',
        ];
        $object     = new ParametersTemplate();
        $reflection = new ReflectionProperty($object, 'parameters');
        $reflection->setAccessible(true);

        $object->setParams($firstParams);
        $this->assertSame($firstParams, $reflection->getValue($object));

        $object->setParams($secondParams);
        $this->assertSame($secondParams, $reflection->getValue($object));
    }

    public function testAddParamsAddsParams()
    {
        $firstParams = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $secondParams = [
            'bat' => 'bas',
            'con' => 'com',
        ];
        $expected = [
            'foo' => 'bar',
            'bat' => 'bas',
            'con' => 'com',
        ];
        $object = new ParametersTemplate();
        $object->addParams($firstParams);
        $object->addParams($secondParams);

        $reflection = new ReflectionProperty($object, 'parameters');
        $reflection->setAccessible(true);
        $this->assertSame($expected, $reflection->getValue($object));
    }

    public function testSetParam()
    {
        $object = new ParametersTemplate();
        $object->setParam('foo', 'bar');

        $reflection = new ReflectionProperty($object, 'parameters');
        $reflection->setAccessible(true);
        $params = $reflection->getValue($object);

        $this->assertTrue(isset($params['foo']));
        $this->assertSame('bar', $params['foo']);
    }

    public function testGetParamReturnsValueOfParameterIfParameterExists()
    {
        $object = new ParametersTemplate();
        $object->setParam('foo', 'bar');
        $this->assertSame('bar', $object->getParam('foo'));
    }

    public function testGetParamReturnsDefaultIfParameterNotExists()
    {
        $object = new ParametersTemplate();
        $this->assertSame('bar', $object->getParam('foo', 'bar'));
    }

    public function testGetParams()
    {
        $params = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $object = new ParametersTemplate();
        $object->setParams($params);

        $this->assertSame($params, $object->getParams());
    }
}
