<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Options;

use ReflectionProperty;

class OptionsTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'OptionsTemplate.php';
    }

    public function testSetOptionsSetsOptions()
    {
        $options = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $template = new OptionsTemplate();
        $template->setOptions($options);

        $reflection = new ReflectionProperty($template, 'options');
        $reflection->setAccessible(true);
        $this->assertSame($options, $reflection->getValue($template));
    }

    public function testsetOptionsCallSetter()
    {
        $options = [
            'item' => 'foo',
        ];
        $template = $this->getMock(OptionsTemplate::CLASS, ['setItem']);
        $template
            ->expects($this->once())
            ->method('setItem')
            ->with($this->identicalTo('foo'));

        $template->setOptions($options);
    }

    public function testGetOptions()
    {
        $options = [
            'foo' => 'bar',
            'bat' => 'baz',
        ];
        $template = new OptionsTemplate();
        $template->setOptions($options);
        $this->assertSame($options, $template->getOptions());
    }

    public function testGetOptionReturnsOptionValue()
    {
        $options = [
            'foo' => 'bar',
        ];
        $template = new OptionsTemplate();
        $template->setOptions($options);
        $this->assertSame('bar', $template->getOption('foo'));
    }

    public function testGetOptionReturnsDefault()
    {
        $template = new OptionsTemplate();
        $this->assertSame('bar', $template->getOption('foo', 'bar'));
    }
}
