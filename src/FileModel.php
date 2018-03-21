<?php

namespace Recca0120\Repository;

abstract class FileModel extends SqliteModel
{
    /**
     * loadFromResource.
     *
     * @return \Illuminate\Support\Collection
     */
    abstract protected function loadFromResource();

    /**
     * initializeTable.
     *
     * @param string $table
     * @return void
     */
    protected function initializeTable($table)
    {
        $this->loadFromResource()->chunk(10)->each(function ($items) {
            $this->newQuery()->insert($items->toArray());
        });
    }
}
