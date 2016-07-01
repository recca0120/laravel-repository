<?php

namespace Recca0120\Repository\Criteria;

class Action
{
    /**
     * $type.
     *
     * @var string
     */
    public $type;

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
     * __construct.
     * @method __construct
     * @param string $type
     * @param string $method
     * @param array $parameters
     */
    public function __construct($type, $method, $parameters = [])
    {
        $this->type = $type;
        $this->method = $method;
        $this->parameters = $parameters;
    }
}
