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
 * The interface of parametric object.
 */
interface ParametersInterface
{
    /**
     * Sets the parameters.
     *
     * @param array $parameters The parameters
     */
    public function setParams(array $parameters = []);

    /**
     * Adds the parameters.
     *
     * @param array $parameters The parameters
     */
    public function addParams(array $parameters);

    /**
     * Sets the parameter.
     *
     * @param int|string $key   The key of parameter
     * @param mixed      $value The parameter value
     */
    public function setParam($key, $value);

    /**
     * Gets the parameter.
     *
     * @param int|string $key     The key of parameter
     * @param mixed      $default The default value of parameter
     *
     * @return mixed Returns parameter value if any, $default otherwise
     */
    public function getParam($key, $default = null);

    /**
     * Gets the parameters.
     *
     * @return array The parameters
     */
    public function getParams();
}
