<?php

namespace Recca0120\Repository;

use Illuminate\Support\Collection;

abstract class CollectionModel extends FileModel
{
    protected $items = [];

    protected function loadFromResource()
    {
        return $this->items instanceof Collection
            ? $this->items
            : new Collection($this->items);
    }
}
