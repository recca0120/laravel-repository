<?php

namespace Recca0120\Repository;

abstract class Collection extends Sqlite
{
    protected $items = [];

    protected function handleTableCreated()
    {
        $this->newQuery()->insert($this->items);
    }
}
