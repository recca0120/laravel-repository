<?php

namespace Recca0120\Repository;

use Recca0120\Repository\Criteria\Collection;
use Recca0120\Repository\Criteria\Expression;
use ReflectionClass;

class Criteria extends Collection
{
    /**
     * alias raw.
     *
     * @param mixed $value
     *
     * @return \Recca0120\Repository\Criteria\Expression
     */
    public static function expr($value)
    {
        return static::raw($value);
    }

    /**
     * @param mixed $value
     *
     * @return \Recca0120\Repository\Criteria\Expression
     */
    public static function raw($value)
    {
        return new Expression($value);
    }

    /**
     * Creates an instance of the class.
     *
     * @return Criteria
     */
    public static function create()
    {
        $args = func_get_args();

        switch (count($args)) {
            case 0:
                return new static();
            case 1:
                return new static($args[0]);
            case 2:
                return new static($args[0], $args[1]);
            case 3:
                return new static($args[0], $args[1], $args[2]);
            case 4:
                return new static($args[0], $args[1], $args[2], $args[3]);
            default:
                $reflectionClass = new ReflectionClass(static::class);

                return $reflectionClass->newInstanceArgs(func_get_args());
        }
    }
}
