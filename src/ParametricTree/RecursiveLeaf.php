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

use Es\Container\AbstractContainer;
use Es\Container\Conversion\ConversionTrait;
use Es\Container\Parameters\ParametersTrait;
use Es\Container\Property\PropertyTrait;
use InvalidArgumentException;
use RuntimeException;

/**
 * The leaf of parametric tree with the recursive iteration.
 */
class RecursiveLeaf extends AbstractContainer implements RecursiveLeafInterface
{
    use ConversionTrait,
        ParametersTrait,
        PropertyTrait;

    /**
     * The current leaf.
     *
     * @var null|false|RecursiveLeafInterface
     */
    protected $current;

    /**
     * The children's leaves.
     *
     * @var array
     */
    protected $children = [];

    /**
     * The key of leaf, which is unique within the tree.
     *
     * @var null|int|string
     */
    protected $uniqueKey;

    /**
     * The depth of leaf in the tree.
     *
     * @var null|int
     */
    protected $depth;

    /**
     * Adds the child leaf.
     *
     * @param RecursiveLeafInterface $leaf The leaf
     */
    public function addChild(RecursiveLeafInterface $leaf)
    {
        $leaf->setDepth($this->depth + 1);
        $this->children[] = $leaf;
    }

    /**
     * Gets the variable.
     *
     * @param int|string $name    The variable name
     * @param mixed      $default The default value
     *
     * @return mixed Returns the value of variable if variable exists,
     *               $default otherwise
     */
    public function get($name, $default = null)
    {
        if (isset($this->container[$name])) {
            return $this->container[$name];
        }

        return $default;
    }

    /**
     * Sets the unique key of leaf.
     *
     * @param int|string $uniqueKey The unique key
     *
     * @throws \RuntimeException         If the unique key was already set
     * @throws \InvalidArgumentException If type of specified key is invalid
     */
    public function setUniqueKey($uniqueKey)
    {
        if (! is_null($this->uniqueKey)) {
            throw new RuntimeException('The unique key was already set.');
        }
        if (! is_int($uniqueKey) && ! is_string($uniqueKey)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid type of specified unique key; must be an integer or '
                . 'an string, "%s" received.',
                gettype($uniqueKey)
            ));
        }
        $this->uniqueKey = $uniqueKey;
    }

    /**
     * Gets the unique key.
     *
     * @return null|int|string Returns the unique key, if any
     */
    public function getUniqueKey()
    {
        return $this->uniqueKey;
    }

    /**
     * Sets the depth of leaf in the tree.
     *
     * @param int $depth The depth of leaf in the tree
     *
     * @throws \RuntimeException         If the depth was already set
     * @throws \InvalidArgumentException If type of specified depth is invalid
     */
    public function setDepth($depth)
    {
        if (! is_null($this->depth)) {
            throw new RuntimeException('The depth was already set.');
        }
        if (! is_int($depth)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid type of specified depth; must be an integer, '
                . '"%s" received.',
                gettype($depth)
            ));
        }
        $this->depth = $depth;
    }

    /**
     * Gets the depth of leaf in the tree.
     *
     * @return null|int Returns the depth of leaf in the tree, if any
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Gets count of children leaves.
     *
     * @return int
     */
    public function count()
    {
        return count($this->children);
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
            return $this;
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
        if (is_null($this->current)) {
            $this->current = current($this->children);

            return;
        }
        if ($this->current instanceof RecursiveLeafInterface) {
            $this->current->next();
            if ($this->current->valid()) {
                return;
            }
        }
        $this->current = next($this->children);
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
            return $this->getUniqueKey();
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
        foreach ($this->children as $item) {
            $item->rewind();
        }
        reset($this->children);
    }

    /**
     * Checks if current position is valid.
     *
     * @return bool Returns true on success, false otherwise
     */
    public function valid()
    {
        if (is_null($this->current)) {
            return true;
        }
        if ($this->current instanceof RecursiveLeafInterface) {
            return $this->current->valid();
        }

        return false;
    }
}
