<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Options;

/**
 * Provides the feature of options.
 */
trait OptionsTrait
{
    /**
     * The options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Sets the options.
     * If the object has a corresponding setter - use it to set values.
     *
     * @param array $options The options
     *
     * @return self
     */
    public function setOptions(array $options)
    {
        foreach ($options as $name => $value) {
            $setter = 'set' . str_replace('_', '', $name);
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }
        $this->options = $options;

        return $this;
    }

    /**
     * Gets the options.
     *
     * @return array The options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Gets the option.
     *
     * @param string $name    The name of option
     * @param mixed  $default Optiona; null by default. The default value
     *
     * @return mixed Returns the value of option, if any, $default otherwise
     */
    public function getOption($name, $default = null)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        return $default;
    }
}
