<?php

namespace Recca0120\Repository;

use Recca0120\Repository\Criteria\Collection;
use Recca0120\Repository\Criteria\Expression;
use Recca0120\Repository\Criteria\Item;

class Criteria extends Collection
{
    protected $types = [
        'select',
        'where',
        'join',
        'having',
        'order',
        'union',
        'groupBy',
        'on',
        'with',
    ];

    public function __call($method, $parameters)
    {
        if (preg_match('/'.implode('|', $this->types).'/i', $method, $match) !== false) {
            $this->push(new Item($match[0], $method, $parameters));
        }

        return $this;
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
    public static function create()
    {
        return new static();
    }
}
