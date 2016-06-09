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
use Iterator;

/**
 * Interface of parametric tree with recursive iteration.
 */
interface RecursiveTreeInterface extends Countable, Iterator
{
    /**
     * Sets the prototype of leaf.
     *
     * @param RecursiveLeafInterface $prototype
     */
    public function setLeafPrototype(RecursiveLeafInterface $prototype);

    /**
     * Gets the prototype of leaf.
     *
     * @return RecursiveLeafInterface
     */
    public function getLeafPrototype();

    /**
     * Builds the leaf.
     *
     * @param null|int|string $uniqueKey Optional; null by default. The key,
     *                                   which is unique within the tree
     * @param null|int|string $parentKey Optional; null by default. The key of
     *                                   parent leaf
     *
     * @throws \InvalidArgumentException
     */
    public function buildLeaf($uniqueKey = null, $parentKey = null);

    /**
     * Is there a leaf with the specified key?
     *
     * @param int|string $uniqueKey The unique key of leaf
     *
     * @return bool Returns true on success, false otherwise
     */
    public function hasLeaf($uniqueKey);

    /**
     * Gets the specified leaf.
     *
     * @param int|string $uniqueKey The unique key of leaf
     *
     * @throws \InvalidArgumentException If the specified leaf is unknown
     *
     * @return RecursiveLeafInterface The specified leaf
     */
    public function getLeaf($uniqueKey);

    /**
     * Gets count leaves in crown of tree.
     *
     * @return int The count of leaves in crown of tree
     */
    public function getSize();
}
