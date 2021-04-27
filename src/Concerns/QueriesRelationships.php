<?php

namespace Recca0120\Repository\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Recca0120\Repository\Method;

trait QueriesRelationships
{
    /**
     * Add a relationship count / exists condition to the query.
     *
     * @param string $relation
     * @param string $operator
     * @param int $count
     * @param string $boolean
     * @param \Closure|null $callback
     * @return $this
     */
    public function has($relation, $operator = '>=', $count = 1, $boolean = 'and', Closure $callback = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $operator, $count, $boolean, $callback]);

        return $this;
    }

    /**
     * Add a relationship count / exists condition to the query with an "or".
     *
     * @param string $relation
     * @param string $operator
     * @param int $count
     * @return $this
     */
    public function orHas($relation, $operator = '>=', $count = 1)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $operator, $count]);

        return $this;
    }

    /**
     * Add a relationship count / exists condition to the query.
     *
     * @param string $relation
     * @param string $boolean
     * @param \Closure|null $callback
     * @return $this
     */
    public function doesntHave($relation, $boolean = 'and', Closure $callback = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $boolean, $callback]);

        return $this;
    }

    /**
     * Add a relationship count / exists condition to the query with where clauses.
     *
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return $this
     */
    public function whereHas($relation, Closure $callback = null, $operator = '>=', $count = 1)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $callback, $operator, $count]);

        return $this;
    }

    /**
     * Add a relationship count / exists condition to the query with where clauses and an "or".
     *
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return $this
     */
    public function orWhereHas($relation, Closure $callback = null, $operator = '>=', $count = 1)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $callback, $operator, $count]);

        return $this;
    }

    /**
     * Add a relationship count / exists condition to the query with where clauses.
     *
     * @param string $relation
     * @param \Closure|null $callback
     * @return $this
     */
    public function whereDoesntHave($relation, Closure $callback = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $callback]);

        return $this;
    }

    /**
     * Add subselect queries to count the relations.
     *
     * @param mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relations]);

        return $this;
    }

    /**
     * Add subselect queries to include the max of the relation's column.
     *
     * @param string|array $relation
     * @param string $column
     * @return $this
     */
    public function withMax($relation, $column)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $column]);

        return $this;
    }

    /**
     * Add subselect queries to include the min of the relation's column.
     *
     * @param string|array $relation
     * @param string $column
     * @return $this
     */
    public function withMin($relation, $column)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $column]);

        return $this;
    }

    /**
     * Add subselect queries to include the sum of the relation's column.
     *
     * @param string|array $relation
     * @param string $column
     * @return $this
     */
    public function withSum($relation, $column)
    {
        $this->methods[] = new Method(__FUNCTION__, [$relation, $column]);

        return $this;
    }

    /**
     * Add subselect queries to include the average of the relation's column.
     *
     * @param string|array $relation
     * @param string $column
     * @return $this
     */
    public function withAvg($relation, $column)
    {
        return $this->withAggregate($relation, $column, 'avg');
    }

    /**
     * Merge the where constraints from another query to the current query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $from
     * @return $this
     */
    public function mergeConstraintsFrom(Builder $from)
    {
        $this->methods[] = new Method(__FUNCTION__, [$from]);

        return $this;
    }
}
