<?php

namespace Recca0120\Repository;

use ReflectionClass;
use BadMethodCallException;

class Criteria
{
    /**
     * $actions.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * $allowTypes.
     *
     * @var array
     */
    protected $allowTypes = [
        'from',
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
        'has',
    ];

    /**
     *  _call.
     *
     * @param string $method
     * @param mixed $parameters
     * @return \Recca0120\Repository\Criteria
     */
    public function __call($method, $parameters)
    {
        if (preg_match('/'.implode('|', $this->allowTypes).'/i', $method, $match)) {
            $this->actions[] = new Action($match[0], $method, $parameters);

            return $this;
        }

        throw new BadMethodCallException('Call to undefined method '.static::class."::{$method}()");
    }

    /**
     * __callStatic.
     *
     * @param string $method
     * @param array $parameters
     * @return static
     */
    public static function __callStatic($method, $parameters)
    {
        $criteria = new static();

        return call_user_func_array([$criteria, $method], $parameters);
    }

    /**
     * all.
     *
     * @return array
     */
    public function all()
    {
        return $this->actions;
    }

    /**
     * alias raw.
     *
     * @param mixed $value
     * @return Expression
     */
    public static function expr($value)
    {
        return static::raw($value);
    }

    /**
     * @param mixed $value
     * @return \Recca0120\Repository\Expression
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

                return $reflectionClass->newInstanceArgs($args);
        }
    }
}
