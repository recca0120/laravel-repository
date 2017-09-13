<?php

namespace Recca0120\Repository;

class Method
{
    /**
     * $method.
     *
     * @var string
     */
    public $method;

    /**
     * $parameters.
     *
     * @var mixed
     */
    public $parameters;

    /**
     * @param string $method
     * @param mixed  $parameters
     */
    public function __construct($method, $parameters = null)
    {
        $this->method = $method;
        $this->parameters = $parameters;
    }

    public function exec($object)
    {
        return call_user_func_array([$object, $this->method], $this->parameters);
    }
}
