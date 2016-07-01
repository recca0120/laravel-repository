<?php

namespace Recca0120\Repository\Traits;

use Closure;

trait Collection
{
    /**
     * $items.
     *
     * @var array
     */
    protected $items = [];

    // /**
    //  * each.
    //  *
    //  * @method each
    //  *
    //  * @param Closure $callable
    //  *
    //  * @return self
    //  */
    // public function each(Closure $callable)
    // {
    //     foreach ($this->items as $item) {
    //         $callable($item);
    //     }
    //
    //     return $this;
    // }
    //
    // /**
    //  * map.
    //  *
    //  * @method map
    //  *
    //  * @param Closure $callable
    //  *
    //  * @return array
    //  */
    // public function map(Closure $callable)
    // {
    //     $result = [];
    //     foreach ($this->items as $item) {
    //         $result[] = $callable($item);
    //     }
    //
    //     return $result;
    // }

    /**
     * all.
     *
     * @method all
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
}
