<?php

namespace Recca0120\Repository\Core;

class Expression
{
    /**
     * $value.
     *
     * @var
     */
    protected $value;

    /**
     * __construct.
     *
     * @method __construct
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * getValue.
     *
     * @method getValue
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * __toString.
     *
     * @method __toString
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
}
