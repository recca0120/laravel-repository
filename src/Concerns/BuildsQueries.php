<?php

namespace Recca0120\Repository\Concerns;

use Closure;
use Recca0120\Repository\Method;
use Illuminate\Database\Query\Builder;

trait BuildsQueries
{
    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $this->methods[] = new Method(__FUNCTION__, [$columns]);

        return $this;
    }

    /**
     * Add a new "raw" select expression to the query.
     *
     * @param  string  $expression
     * @param  array   $bindings
     * @return $this
     */
    public function selectRaw($expression, array $bindings = [])
    {
        $this->methods[] = new Method(__FUNCTION__, [$expression, $bindings]);

        return $this;
    }

    /**
     * Makes "from" fetch from a subquery.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string $query
     * @param  string  $as
     * @return \Illuminate\Database\Query\Builder|static
     *
     * @throws \InvalidArgumentException
     */
    public function fromSub($query, $as)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $as]);

        return $this;
    }

    /**
     * Add a subselect expression to the query.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string $query
     * @param  string  $as
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function selectSub($query, $as)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $as]);

        return $this;
    }

    /**
     * Add a new select column to the query.
     *
     * @param  array|mixed  $column
     * @return $this
     */
    public function addSelect($column)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column]);

        return $this;
    }

    /**
     * Force the query to only return distinct results.
     *
     * @return $this
     */
    public function distinct()
    {
        $this->methods[] = new Method(__FUNCTION__);

        return $this;
    }

    /**
     * Set the table which the query is targeting.
     *
     * @param  string  $table
     * @return $this
     */
    public function from($table)
    {
        $this->methods[] = new Method(__FUNCTION__, [$table]);

        return $this;
    }

    /**
     * Add a join clause to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @param  string  $type
     * @param  bool    $where
     * @return $this
     */
    public function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$table, $first, $operator, $second, $type, $where]);

        return $this;
    }

    /**
     * Add a "join where" clause to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @param  string  $type
     * @return $this
     */
    public function joinWhere($table, $first, $operator, $second, $type = 'inner')
    {
        $this->methods[] = new Method(__FUNCTION__, [$table, $first, $operator, $second, $type]);

        return $this;
    }

    /**
     * Add a subquery join clause to the query.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string $query
     * @param  string  $as
     * @param  string  $first
     * @param  string|null  $operator
     * @param  string|null  $second
     * @param  string  $type
     * @param  bool    $where
     * @return \Illuminate\Database\Query\Builder|static
     *
     * @throws \InvalidArgumentException
     */
    public function joinSub($query, $as, $first, $operator = null, $second = null, $type = 'inner', $where = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $as, $first, $operator, $second, $type, $where]);

        return $this;
    }

    /**
     * Add a left join to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return $this
     */
    public function leftJoin($table, $first, $operator = null, $second = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$table, $first, $operator, $second]);

        return $this;
    }

    /**
     * Add a "join where" clause to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return $this
     */
    public function leftJoinWhere($table, $first, $operator, $second)
    {
        $this->methods[] = new Method(__FUNCTION__, [$table, $first, $operator, $second]);

        return $this;
    }

    /**
     * Add a subquery left join to the query.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string $query
     * @param  string  $as
     * @param  string  $first
     * @param  string|null  $operator
     * @param  string|null  $second
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function leftJoinSub($query, $as, $first, $operator = null, $second = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $as, $first, $operator, $second]);

        return $this;
    }

    /**
     * Add a right join to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return $this
     */
    public function rightJoin($table, $first, $operator = null, $second = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$table, $first, $operator, $second]);

        return $this;
    }

    /**
     * Add a "right join where" clause to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return $this
     */
    public function rightJoinWhere($table, $first, $operator, $second)
    {
        $this->methods[] = new Method(__FUNCTION__, [$table, $first, $operator, $second]);

        return $this;
    }

    /**
     * Add a subquery right join to the query.
     *
     * @param  \Closure|\Illuminate\Database\Query\Builder|string $query
     * @param  string  $as
     * @param  string  $first
     * @param  string|null  $operator
     * @param  string|null  $second
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function rightJoinSub($query, $as, $first, $operator = null, $second = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $as, $first, $operator, $second]);

        return $this;
    }

    /**
     * Add a "cross join" clause to the query.
     *
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return $this
     */
    public function crossJoin($table, $first = null, $operator = null, $second = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$table, $first, $operator, $second]);

        return $this;
    }

    /**
     * Merge an array of where clauses and bindings.
     *
     * @param  array  $wheres
     * @param  array  $bindings
     * @return void
     */
    public function mergeWheres($wheres, $bindings)
    {
        $this->methods[] = new Method(__FUNCTION__, [$wheres, $bindings]);

        return $this;
    }

    /**
     * Pass the query to a given callback.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function tap($callback)
    {
        $this->methods[] = new Method(__FUNCTION__, [$callback]);

        return $this;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  string  $operator
     * @param  mixed   $value
     * @param  string  $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value, $boolean]);

        return $this;
    }

    /**
     * Add an "or where" clause to the query.
     *
     * @param  \Closure|string  $column
     * @param  string  $operator
     * @param  mixed   $value
     * @return $this
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value]);

        return $this;
    }

    /**
     * Add a "where" clause comparing two columns to the query.
     *
     * @param  string|array  $first
     * @param  string|null  $operator
     * @param  string|null  $second
     * @param  string|null  $boolean
     * @return $this
     */
    public function whereColumn($first, $operator = null, $second = null, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$first, $operator, $second, $boolean]);

        return $this;
    }

    /**
     * Add an "or where" clause comparing two columns to the query.
     *
     * @param  string|array  $first
     * @param  string|null  $operator
     * @param  string|null  $second
     * @return $this
     */
    public function orWhereColumn($first, $operator = null, $second = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$first, $operator, $second]);

        return $this;
    }

    /**
     * Add a raw where clause to the query.
     *
     * @param  string  $sql
     * @param  mixed   $bindings
     * @param  string  $boolean
     * @return $this
     */
    public function whereRaw($sql, $bindings = [], $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$sql, $bindings, $boolean]);

        return $this;
    }

    /**
     * Add a raw or where clause to the query.
     *
     * @param  string  $sql
     * @param  array   $bindings
     * @return $this
     */
    public function orWhereRaw($sql, array $bindings = [])
    {
        $this->methods[] = new Method(__FUNCTION__, [$sql, $bindings]);

        return $this;
    }

    /**
     * Add a "where in" clause to the query.
     *
     * @param  string  $column
     * @param  mixed   $values
     * @param  string  $boolean
     * @param  bool    $not
     * @return $this
     */
    public function whereIn($column, $values, $boolean = 'and', $not = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values, $boolean, $not]);

        return $this;
    }

    /**
     * Add an "or where in" clause to the query.
     *
     * @param  string  $column
     * @param  mixed   $values
     * @return $this
     */
    public function orWhereIn($column, $values)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values]);

        return $this;
    }

    /**
     * Add a "where not in" clause to the query.
     *
     * @param  string  $column
     * @param  mixed   $values
     * @param  string  $boolean
     * @return $this
     */
    public function whereNotIn($column, $values, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values, $boolean]);

        return $this;
    }

    /**
     * Add an "or where not in" clause to the query.
     *
     * @param  string  $column
     * @param  mixed   $values
     * @return $this
     */
    public function orWhereNotIn($column, $values)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values]);

        return $this;
    }

    /**
     * Add a "where null" clause to the query.
     *
     * @param  string  $column
     * @param  string  $boolean
     * @param  bool    $not
     * @return $this
     */
    public function whereNull($column, $boolean = 'and', $not = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $boolean, $not]);

        return $this;
    }

    /**
     * Add an "or where null" clause to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function orWhereNull($column)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column]);

        return $this;
    }

    /**
     * Add a "where not null" clause to the query.
     *
     * @param  string  $column
     * @param  string  $boolean
     * @return $this
     */
    public function whereNotNull($column, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $boolean]);

        return $this;
    }

    /**
     * Add a where between statement to the query.
     *
     * @param  string  $column
     * @param  array   $values
     * @param  string  $boolean
     * @param  bool  $not
     * @return $this
     */
    public function whereBetween($column, array $values, $boolean = 'and', $not = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values, $boolean, $not]);

        return $this;
    }

    /**
     * Add an or where between statement to the query.
     *
     * @param  string  $column
     * @param  array   $values
     * @return $this
     */
    public function orWhereBetween($column, array $values)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values]);

        return $this;
    }

    /**
     * Add a where not between statement to the query.
     *
     * @param  string  $column
     * @param  array   $values
     * @param  string  $boolean
     * @return $this
     */
    public function whereNotBetween($column, array $values, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values, $boolean]);

        return $this;
    }

    /**
     * Add an or where not between statement to the query.
     *
     * @param  string  $column
     * @param  array   $values
     * @return $this
     */
    public function orWhereNotBetween($column, array $values)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $values]);

        return $this;
    }

    /**
     * Add an "or where not null" clause to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function orWhereNotNull($column)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column]);

        return $this;
    }

    /**
     * Add a "where date" statement to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereDate($column, $operator, $value = null, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value, $boolean]);

        return $this;
    }

    /**
     * Add an "or where date" statement to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  string  $value
     * @return $this
     */
    public function orWhereDate($column, $operator, $value)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value]);

        return $this;
    }

    /**
     * Add a "where time" statement to the query.
     *
     * @param  string  $column
     * @param  string   $operator
     * @param  int   $value
     * @param  string   $boolean
     * @return $this
     */
    public function whereTime($column, $operator, $value, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value, $boolean]);

        return $this;
    }

    /**
     * Add an "or where time" statement to the query.
     *
     * @param  string  $column
     * @param  string   $operator
     * @param  int   $value
     * @return $this
     */
    public function orWhereTime($column, $operator, $value)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value]);

        return $this;
    }

    /**
     * Add a "where day" statement to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereDay($column, $operator, $value = null, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value, $boolean]);

        return $this;
    }

    /**
     * Add a "where month" statement to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereMonth($column, $operator, $value = null, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value, $boolean]);

        return $this;
    }

    /**
     * Add a "where year" statement to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereYear($column, $operator, $value = null, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value, $boolean]);

        return $this;
    }

    /**
     * Add a nested where statement to the query.
     *
     * @param  \Closure $callback
     * @param  string   $boolean
     * @return $this
     */
    public function whereNested(Closure $callback, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$callback, $boolean]);

        return $this;
    }

    /**
     * Add another query builder as a nested where to the query builder.
     *
     * @param  $this $query
     * @param  string  $boolean
     * @return $this
     */
    public function addNestedWhereQuery($query, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $boolean]);

        return $this;
    }

    /**
     * Add an exists clause to the query.
     *
     * @param  \Closure $callback
     * @param  string   $boolean
     * @param  bool     $not
     * @return $this
     */
    public function whereExists(Closure $callback, $boolean = 'and', $not = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$callback, $boolean, $not]);

        return $this;
    }

    /**
     * Add an or exists clause to the query.
     *
     * @param  \Closure $callback
     * @param  bool     $not
     * @return $this
     */
    public function orWhereExists(Closure $callback, $not = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$callback, $not]);

        return $this;
    }

    /**
     * Add a where not exists clause to the query.
     *
     * @param  \Closure $callback
     * @param  string   $boolean
     * @return $this
     */
    public function whereNotExists(Closure $callback, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$callback, $boolean]);

        return $this;
    }

    /**
     * Add a where not exists clause to the query.
     *
     * @param  \Closure  $callback
     * @return $this
     */
    public function orWhereNotExists(Closure $callback)
    {
        $this->methods[] = new Method(__FUNCTION__, [$callback]);

        return $this;
    }

    /**
     * Add an exists clause to the query.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @param  string  $boolean
     * @param  bool  $not
     * @return $this
     */
    public function addWhereExistsQuery(Builder $query, $boolean = 'and', $not = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $boolean, $not]);

        return $this;
    }

    /**
     * Handles dynamic "where" clauses to the query.
     *
     * @param  string  $method
     * @param  string  $parameters
     * @return $this
     */
    public function dynamicWhere($method, $parameters)
    {
        $this->methods[] = new Method(__FUNCTION__, [$method, $parameters]);

        return $this;
    }

    /**
     * Add a "group by" clause to the query.
     *
     * @param  array  ...$groups
     * @return $this
     */
    public function groupBy()
    {
        $this->methods[] = new Method(__FUNCTION__, func_get_args());

        return $this;
    }

    /**
     * Add a "having" clause to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  string  $value
     * @param  string  $boolean
     * @return $this
     */
    public function having($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value, $boolean]);

        return $this;
    }

    /**
     * Add a "or having" clause to the query.
     *
     * @param  string  $column
     * @param  string  $operator
     * @param  string  $value
     * @return $this
     */
    public function orHaving($column, $operator = null, $value = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $operator, $value]);

        return $this;
    }

    /**
     * Add a raw having clause to the query.
     *
     * @param  string  $sql
     * @param  array   $bindings
     * @param  string  $boolean
     * @return $this
     */
    public function havingRaw($sql, array $bindings = [], $boolean = 'and')
    {
        $this->methods[] = new Method(__FUNCTION__, [$sql, $bindings, $boolean]);

        return $this;
    }

    /**
     * Add a raw or having clause to the query.
     *
     * @param  string  $sql
     * @param  array   $bindings
     * @return $this
     */
    public function orHavingRaw($sql, array $bindings = [])
    {
        $this->methods[] = new Method(__FUNCTION__, [$sql, $bindings]);

        return $this;
    }

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column, $direction]);

        return $this;
    }

    /**
     * Add a descending "order by" clause to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function orderByDesc($column)
    {
        $this->methods[] = new Method(__FUNCTION__, [$column]);

        return $this;
    }

    /**
     * Add an "order by" clause for a timestamp to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function latest($column = 'created_at')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column]);

        return $this;
    }

    /**
     * Add an "order by" clause for a timestamp to the query.
     *
     * @param  string  $column
     * @return $this
     */
    public function oldest($column = 'created_at')
    {
        $this->methods[] = new Method(__FUNCTION__, [$column]);

        return $this;
    }

    /**
     * Put the query's results in random order.
     *
     * @param  string  $seed
     * @return $this
     */
    public function inRandomOrder($seed = '')
    {
        $this->methods[] = new Method(__FUNCTION__, [$seed]);

        return $this;
    }

    /**
     * Add a raw "order by" clause to the query.
     *
     * @param  string  $sql
     * @param  array  $bindings
     * @return $this
     */
    public function orderByRaw($sql, $bindings = [])
    {
        $this->methods[] = new Method(__FUNCTION__, [$sql, $bindings]);

        return $this;
    }

    /**
     * Alias to set the "offset" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function skip($value)
    {
        $this->methods[] = new Method(__FUNCTION__, [$value]);

        return $this;
    }

    /**
     * Set the "offset" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function offset($value)
    {
        $this->methods[] = new Method(__FUNCTION__, [$value]);

        return $this;
    }

    /**
     * Alias to set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function take($value)
    {
        $this->methods[] = new Method(__FUNCTION__, [$value]);

        return $this;
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function limit($value)
    {
        $this->methods[] = new Method(__FUNCTION__, [$value]);

        return $this;
    }

    /**
     * Set the limit and offset for a given page.
     *
     * @param  int  $page
     * @param  int  $perPage
     * @return $this
     */
    public function forPage($page, $perPage = 15)
    {
        $this->methods[] = new Method(__FUNCTION__, [$page, $perPage]);

        return $this;
    }

    /**
     * Constrain the query to the next "page" of results after a given ID.
     *
     * @param  int  $perPage
     * @param  int  $lastId
     * @param  string  $column
     * @return $this
     */
    public function forPageAfterId($perPage = 15, $lastId = 0, $column = 'id')
    {
        $this->methods[] = new Method(__FUNCTION__, [$perPage, $lastId, $column]);

        return $this;
    }

    /**
     * Add a union statement to the query.
     *
     * @param  \Illuminate\Database\Query\Builder|\Closure  $query
     * @param  bool  $all
     * @return $this
     */
    public function union($query, $all = false)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query, $all]);

        return $this;
    }

    /**
     * Add a union all statement to the query.
     *
     * @param  \Illuminate\Database\Query\Builder|\Closure  $query
     * @return $this
     */
    public function unionAll($query)
    {
        $this->methods[] = new Method(__FUNCTION__, [$query]);

        return $this;
    }

    /**
     * Lock the selected rows in the table.
     *
     * @param  string|bool  $value
     * @return $this
     */
    public function lock($value = true)
    {
        $this->methods[] = new Method(__FUNCTION__, [$value]);

        return $this;
    }

    /**
     * Lock the selected rows in the table for updating.
     *
     * @return $this
     */
    public function lockForUpdate()
    {
        $this->methods[] = new Method(__FUNCTION__);

        return $this;
    }

    /**
     * Share lock the selected rows in the table.
     *
     * @return $this
     */
    public function sharedLock()
    {
        $this->methods[] = new Method(__FUNCTION__);

        return $this;
    }

    /**
     * Apply the callback's query changes if the given "value" is true.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @param  callable  $default
     * @return $this
     */
    public function when($value, $callback, $default = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$value, $callback, $default]);

        return $this;
    }

    /**
     * Apply the callback's query changes if the given "value" is false.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @param  callable  $default
     * @return $this
     */
    public function unless($value, $callback, $default = null)
    {
        $this->methods[] = new Method(__FUNCTION__, [$value, $callback, $default]);

        return $this;
    }

    /**
     * Use the write pdo for query.
     *
     * @return $this
     */
    public function useWritePdo()
    {
        $this->methods[] = new Method(__FUNCTION__);

        return $this;
    }
}
