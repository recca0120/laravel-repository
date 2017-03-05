<?php

namespace Recca0120\Repository;

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
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * getValue.
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }
}
