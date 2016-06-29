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

use Es\Container\Options\OptionsTrait;
use LogicException;

class OptionsTemplate
{
    use OptionsTrait;

    public function setItem($arg)
    {
        throw new LogicException(sprintf('The "%s" is stub.', __METHOD__));
    }
}
