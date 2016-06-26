<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Test\Converter;

use Es\Container\Converter\Converter;

class ConverterTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once 'ConverterTraitTemplate.php';
    }

    public function testSetConverter()
    {
        $converter = $this->getMock(Converter::CLASS);
        $template  = new ConverterTraitTemplate();
        $template->setConverter($converter);
        $this->assertSame($converter, $template->getConverter());
    }

    public function testGetConverter()
    {
        $template  = new ConverterTraitTemplate();
        $converter = $template->getConverter();
        $this->assertInstanceOf(Converter::CLASS, $converter);
    }
}
