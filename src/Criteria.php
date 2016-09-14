<?php

namespace Recca0120\Repository;

use ReflectionClass;
use BadMethodCallException;
use Recca0120\Repository\Core\Action;
use Recca0120\Repository\Core\Expression;

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
     * all.
     *
     * @method all
     *
     * @return array
     */
    public function all()
    {
        return $this->actions;
    }

    /**
     * push.
     *
     * @method push
     *
     * @param \Recca0120\Repository\Core\Action $action
     *
     * @return self
     */
    public function push(Action $action)
    {
        array_push($this->actions, $action);

        return $this;
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
        if (preg_match('/'.implode('|', $this->allowTypes).'/i', $method, $match) != false) {
            $this->push(new Action($match[0], $method, $parameters));

            return $this;
        }

        throw new BadMethodCallException('Call to undefined method '.static::class."::{$method}()");
    }

    /**
     * alias raw.
     *
     * @param mixed $value
     *
     * @return \Recca0120\Repository\CriteriaExpression
     */
    public static function expr($value)
    {
        return static::raw($value);
    }

    /**
     * @param mixed $value
     *
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

                return $reflectionClass->newInstanceArgs(func_get_args());
        }
    }

    /**
     * __callStatic.
     *
     * @method __callStatic
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return static
     */
    public static function __callStatic($method, $parameters)
    {
        $criteria = new static();

        return call_user_func_array([$criteria, $method], $parameters);
    }
}
