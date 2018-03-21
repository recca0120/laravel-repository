<?php

namespace Recca0120\Repository;

use Illuminate\Support\Collection;

abstract class CollectionModel extends FileModel
{
    /**
     * items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * loadFromResource.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function loadFromResource()
    {
        return $this->items instanceof Collection
            ? $this->items
            : new Collection($this->items);
    }
}
