<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\ParametricTree;

use Countable;
use Es\Container\Conversion\ConversionInterface;
use Es\Container\Parameters\ParametersInterface;
use Es\Container\Property\PropertyInterface;
use Iterator;

/**
 * Interface of leaf with the recursive iteration.
 */
interface RecursiveLeafInterface extends
    Countable,
    ConversionInterface,
    ParametersInterface,
    PropertyInterface,
    Iterator
{
    /**
     * Adds the child leaf.
     *
     * @param RecursiveLeafInterface $leaf The leaf
     */
    public function addChild(RecursiveLeafInterface $leaf);

    /**
     * Sets the unique key of leaf.
     *
     * @param int|string $uniqueKey The unique key
     *
     * @throws \RuntimeException         If the unique key was already set
     * @throws \InvalidArgumentException If type of specified key is invalid
     */
    public function setUniqueKey($uniqueKey);

    /**
     * Gets the unique key.
     *
     * @return null|int|string Returns the unique key, if any
     */
    public function getUniqueKey();

    /**
     * Sets the depth of leaf in the tree.
     *
     * @param int $depth The depth of leaf in the tree
     *
     * @throws \RuntimeException         If the depth was already set
     * @throws \InvalidArgumentException If type of specified depth is invalid
     */
    public function setDepth($depth);

    /**
     * Gets the depth of leaf in the tree.
     *
     * @return null|int Returns the depth of leaf in the tree, if any
     */
    public function getDepth();
}
