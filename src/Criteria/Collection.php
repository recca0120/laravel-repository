<?php

namespace Recca0120\Repository\Criteria;

use BadMethodCallException;
use Recca0120\Repository\Traits\Collection as CollectionTrait;

abstract class Collection
{
    use CollectionTrait;

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
        if (preg_match('/'.implode('|', $this->allowTypes).'/i', $method, $match) != false) {
            $this->push(new Action($match[0], $method, $parameters));

            return $this;
        }

        throw new BadMethodCallException('Call to undefined method '.static::class."::{$method}()");
    }
}
