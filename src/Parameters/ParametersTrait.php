<?php
/**
 * This file is part of the "Easy System" package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Damon Smith <damon.easy.system@gmail.com>
 */
namespace Es\Container\Parameters;

/**
 * Provides the feature of parametric object.
 */
trait ParametersTrait
{
    /**
     * The parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Sets the parameters.
     *
     * @param array $parameters The parameters
     */
    public function setParams(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Adds the parameters.
     *
     * @param array $parameters The parameters
     */
    public function addParams(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * Sets the parameter.
     *
     * @param int|string $key   The key of parameter
     * @param mixed      $value The parameter value
     */
    public function setParam($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Gets the parameter.
     *
     * @param int|string $key     The key of parameter
     * @param mixed      $default The default value of parameter
     *
     * @return mixed Returns parameter value if any, $default otherwise
     */
    public function getParam($key, $default = null)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }

        return $default;
    }

    /**
     * Gets the parameters.
     *
     * @return array The parameters
     */
    public function getParams()
    {
        return $this->parameters;
    }
}
