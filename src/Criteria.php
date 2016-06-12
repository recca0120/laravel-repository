<?php

namespace Recca0120\Repository;

use BadMethodCallException;
use Recca0120\Repository\Criteria\Action;
use Recca0120\Repository\Criteria\Collection;
use Recca0120\Repository\Criteria\Expression;

class Criteria extends Collection
{
    /**
     * $types.
     *
     * @var array
     */
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
        'take',
        'skip',
    ];

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

    /**
     *  _call.
     *
     * @method __call
     *
     * @param string $method
     * @param mixed  $parameters
     *
     * @return \Recca0120\Repository\Criteria
     */
    public function __call($method, $parameters)
    {
        if (preg_match('/'.implode('|', $this->types).'/i', $method, $match) !== false) {
            $this->push(new Action($match[0], $method, $parameters));

            return $this;
        }

        throw new BadMethodCallException("Call to undefined method {$className}::{$method}()");
    }
}
