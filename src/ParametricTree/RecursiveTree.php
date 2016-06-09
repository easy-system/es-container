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

use InvalidArgumentException;
use UnexpectedValueException;

/**
 * Parametric tree with the recursive iteration.
 */
class RecursiveTree implements RecursiveTreeInterface
{
    /**
     * The prototype of leaf.
     *
     * @var RecursiveLeafInterface
     */
    protected $leafPrototype;

    /**
     * The crohn's of tree.
     *
     * @var array
     */
    protected $crown = [];

    /**
     * The root branch of tree.
     *
     * @var array
     */
    protected $branch = [];

    /**
     * The current leaf of tree.
     *
     * @var null|false|RecursiveLeaf
     */
    protected $current = null;

    /**
     * Sets the prototype of leaf.
     *
     * @param RecursiveLeafInterface $prototype
     */
    public function setLeafPrototype(RecursiveLeafInterface $prototype)
    {
        $this->leafPrototype = $prototype;
    }

    /**
     * Gets the prototype of leaf.
     *
     * @return RecursiveLeafInterface
     */
    public function getLeafPrototype()
    {
        if (! $this->leafPrototype) {
            $this->leafPrototype = new RecursiveLeaf();
        }

        return $this->leafPrototype;
    }

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
    public function buildLeaf($uniqueKey = null, $parentKey = null)
    {
        if (isset($this->crown[$uniqueKey])) {
            throw new InvalidArgumentException(sprintf(
                'The leaf with key "%s" is already exists.',
                $uniqueKey
            ));
        }
        if ($parentKey && ! isset($this->crown[$parentKey])) {
            throw new InvalidArgumentException(sprintf(
                'Unknown leaf "%s" specified as parent.',
                $parentKey
            ));
        }
        $leaf = clone $this->getLeafPrototype();
        $this->injectInCrown($leaf, $uniqueKey);

        if ($parentKey) {
            $parent = $this->crown[$parentKey];
            $parent->addChild($leaf);
        } else {
            $this->branch[$leaf->getUniqueKey()] = $leaf;
            $leaf->setDepth(0);
        }

        return $leaf;
    }

    /**
     * Is there a leaf with the specified key?
     *
     * @param int|string $uniqueKey The unique key of leaf
     *
     * @return bool Returns true on success, false otherwise
     */
    public function hasLeaf($uniqueKey)
    {
        return isset($this->crown[$uniqueKey]);
    }

    /**
     * Gets the specified leaf.
     *
     * @param int|string $uniqueKey The unique key of leaf
     *
     * @throws \InvalidArgumentException If the specified leaf not exists
     *
     * @return RecursiveLeafInterface The specified leaf
     */
    public function getLeaf($uniqueKey)
    {
        if (! isset($this->crown[$uniqueKey])) {
            throw new InvalidArgumentException(sprintf(
                'The leaf with unique key "%s" not exists.',
                $uniqueKey
            ));
        }

        return $this->crown[$uniqueKey];
    }

    /**
     * Gets count leaves in crown of tree.
     *
     * @return int The count of leaves in crown of tree
     */
    public function getSize()
    {
        return count($this->crown);
    }

    /**
     * Gets count of leaves in root branch.
     *
     * @return int The count of leaves in root branch
     */
    public function count()
    {
        return count($this->branch);
    }

    /**
     * Returns the current leaf.
     *
     * @return false|RecursiveLeafInterface Returns the current leaf on success,
     *                                      false otherwise
     */
    public function current()
    {
        if (is_null($this->current)) {
            $this->current = current($this->branch);
        }
        if ($this->current instanceof RecursiveLeafInterface) {
            return $this->current->current();
        }

        return false;
    }

    /**
     * Move forward to next leaf.
     */
    public function next()
    {
        if ($this->current instanceof RecursiveLeafInterface) {
            $this->current->next();
            if ($this->current->valid()) {
                if (! isset($this->crown[$this->key()])) {
                    throw new UnexpectedValueException(sprintf(
                        'Unexpected element with a unique key "%s".',
                        $this->key()
                    ));
                }

                return;
            }
        }
        $this->current = next($this->branch);
    }

    /**
     * Returns the unique key of the current leaf.
     *
     * @return null|int|string Returns the unique key of the current leaf on
     *                         success, null otherwise
     */
    public function key()
    {
        if (is_null($this->current)) {
            $this->current = current($this->branch);
        }
        if ($this->current instanceof RecursiveLeafInterface) {
            return $this->current->key();
        }
    }

    /**
     * Rewinds the Iterator to the root leaf.
     */
    public function rewind()
    {
        $this->current = null;
        foreach ($this->branch as $item) {
            $item->rewind();
        }
        reset($this->branch);
    }

    /**
     * Checks if current position is valid.
     *
     * @return bool Returns true on success, false otherwise
     */
    public function valid()
    {
        if (is_null($this->current)) {
            return ! empty($this->branch);
        }
        if ($this->current instanceof RecursiveLeafInterface) {
            return $this->current->valid();
        }

        return false;
    }

    /**
     * Injects leaf in crown of the tree.
     *
     * @param RecursiveLeafInterface $leaf      The leaf
     * @param int|string             $uniqueKey The unique key of leaf
     */
    protected function injectInCrown(RecursiveLeafInterface $leaf, $uniqueKey = null)
    {
        if (is_null($uniqueKey)) {
            $this->crown[] = null;

            $uniqueKey = key(array_slice($this->crown, -1, 1, true));
        }
        $leaf->setUniqueKey($uniqueKey);
        $this->crown[$uniqueKey] = $leaf;
    }
}
