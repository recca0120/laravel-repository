<?php

namespace Recca0120\Repository\Criteria;

use Closure;

class Collection
{
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
     * @param Item $item
     *
     * @return self
     */
    public function push(Item $item)
    {
        array_push($this->items, $item);

        return $this;
    }
}
