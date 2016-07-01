<?php

namespace Recca0120\Repository;

use Recca0120\Repository\Criteria\Collection;
use Recca0120\Repository\Criteria\Expression;

class Criteria extends Collection
{
    /**
     * __construct.
     *
     * @method __construct
     *
     * @param array $wheres
     */
    public function __construct(array $wheres = [])
    {
        foreach ($wheres as $key => $value) {
            $where = (is_array($value) === true) ? $value : [$key, $value];
            call_user_func_array([$this, 'where'], $where);
        }
    }

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
    public static function create(array $wheres = [])
    {
        return new static($wheres);
    }
}
