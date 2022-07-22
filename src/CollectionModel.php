<?php

namespace Recca0120\Repository;

use Illuminate\Support\Collection;

abstract class CollectionModel extends FileModel
{
    /**
     * items.
     *
     * @var array|Collection
     */
    protected $items = [];

    /**
     * loadFromResource.
     *
     * @return Collection
     */
    protected function loadFromResource()
    {
        return $this->items instanceof Collection
            ? $this->items
            : new Collection($this->items);
    }
}
