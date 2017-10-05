<?php

namespace Recca0120\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

abstract class Sqlite extends Model
{
    /**
     * Get a schema builder instance.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function schema()
    {
        return $this->getConnection()->getSchemaBuilder();
    }

    /**
     * Resolve a connection instance.
     *
     * @param  string|null  $connection
     * @return \Illuminate\Database\Connection
     */
    public static function resolveConnection($connection = null)
    {
        return SqliteConnectionFactory::getInstance()->make();
    }

    /**
     * createSchema.
     *
     * @param  Blueprint $table
     * @return void
     */
    abstract protected function createSchema(Blueprint $table);

    /**
     * Fire the given event for the model.
     *
     * @param  string  $event
     * @param  bool  $halt
     * @return mixed
     */
    protected function fireModelEvent($event, $halt = true)
    {
        if ($event === 'booting') {
            $table = $this->getTable();
            $schema = $this->schema();

            if ($schema->hasTable($table) === false) {
                $schema->create($table, function (Blueprint $table) {
                    $this->createSchema($table);
                });
            }
        }

        return parent::fireModelEvent($event, $halt);
    }
}
