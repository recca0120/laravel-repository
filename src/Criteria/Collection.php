<?php

namespace Recca0120\Repository\Criteria;

use BadMethodCallException;
use Closure;

abstract class Collection
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
     * $items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * each.
     *
     * @method each
     *
     * @param Closure $callable
     *
     * @return self
     */
    public function each(Closure $callable)
    {
        foreach ($this->items as $item) {
            $callable($item);
        }

        return $this;
    }

    /**
     * push.
     *
     * @method push
     *
     * @param Action $item
     *
     * @return self
     */
    public function push(Action $item)
    {
        array_push($this->items, $item);

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
        if (preg_match('/'.implode('|', $this->types).'/i', $method, $match) != false) {
            $this->push(new Action($match[0], $method, $parameters));

            return $this;
        }

        throw new BadMethodCallException('Call to undefined method '.static::class."::{$method}()");
    }
}
