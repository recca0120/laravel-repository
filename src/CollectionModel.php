<?php

namespace Recca0120\Repository;

abstract class CollectionModel extends SqliteModel
{
    protected $items = [];

    protected function handleTableCreated()
    {
        $this->newQuery()->insert($this->items);
    }
}
