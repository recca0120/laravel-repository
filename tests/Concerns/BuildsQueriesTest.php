<?php

namespace Recca0120\Repository\Tests\Concerns;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;

class BuildsQueriesTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_select()
    {
        $criteria = Criteria::create()->select($columns = ['foo', 'bar']);
        $this->assertSame($criteria->toArray(), [[
            'method' => 'select',
            'parameters' => [
                $columns,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_select_raw()
    {
        $criteria = Criteria::create()->selectRaw(
            $expression = 'MAX(id)',
            $bindings = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'selectRaw',
            'parameters' => [
                $expression,
                $bindings,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_select_sub()
    {
        $criteria = Criteria::create()->selectSub(
            $query = 'SELECT * FROM table',
            $as = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'selectSub',
            'parameters' => [
                $query,
                $as,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_add_select()
    {
        $criteria = Criteria::create()->addSelect(
            $column = ['foo']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'addSelect',
            'parameters' => [
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_distinct()
    {
        $criteria = Criteria::create()->distinct();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'distinct',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_from()
    {
        $criteria = Criteria::create()->from(
            $table = 'table'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'from',
            'parameters' => [$table],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_join()
    {
        $criteria = Criteria::create()->join(
            $table = 'table',
            $first = 'first',
            $operator = '=',
            $second = 'second',
            $type = 'left join',
            $where = 'first.id = second.id'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'join',
            'parameters' => [
                $table,
                $first,
                $operator,
                $second,
                $type,
                $where,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_join_where()
    {
        $criteria = Criteria::create()->joinWhere(
            $table = 'table',
            $first = 'first',
            $operator = '=',
            $second = 'second',
            $type = 'left join'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'joinWhere',
            'parameters' => [
                $table,
                $first,
                $operator,
                $second,
                $type,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_left_join()
    {
        $criteria = Criteria::create()->leftJoin(
            $table = 'table',
            $first = 'first',
            $operator = '=',
            $second = 'second'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'leftJoin',
            'parameters' => [
                $table,
                $first,
                $operator,
                $second,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_left_join_where()
    {
        $criteria = Criteria::create()->leftJoinWhere(
            $table = 'table',
            $first = 'first',
            $operator = '=',
            $second = 'second'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'leftJoinWhere',
            'parameters' => [
                $table,
                $first,
                $operator,
                $second,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_right_join()
    {
        $criteria = Criteria::create()->rightJoin(
            $table = 'table',
            $first = 'first',
            $operator = '=',
            $second = 'second'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'rightJoin',
            'parameters' => [
                $table,
                $first,
                $operator,
                $second,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_right_join_where()
    {
        $criteria = Criteria::create()->rightJoinWhere(
            $table = 'table',
            $first = 'first',
            $operator = '=',
            $second = 'second'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'rightJoinWhere',
            'parameters' => [
                $table,
                $first,
                $operator,
                $second,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_cross_join()
    {
        $criteria = Criteria::create()->crossJoin(
            $table = 'table',
            $first = 'first',
            $operator = '=',
            $second = 'second'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'crossJoin',
            'parameters' => [
                $table,
                $first,
                $operator,
                $second,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_tap()
    {
        $criteria = Criteria::create()->tap($callback = function () {
        });
        $this->assertSame($criteria->toArray(), [[
            'method' => 'tap',
            'parameters' => [
                $callback,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where()
    {
        $criteria = Criteria::create()->where(
            $column = 'foo',
            $operator = '=',
            $value = '1',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'where',
            'parameters' => [
                $column,
                $operator,
                $value,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where()
    {
        $criteria = Criteria::create()->orWhere(
            $column = 'foo',
            $operator = '=',
            $value = '1'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhere',
            'parameters' => [
                $column,
                $operator,
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_column()
    {
        $criteria = Criteria::create()->whereColumn(
            $first = 'foo',
            $operator = '=',
            $second = 'bar',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereColumn',
            'parameters' => [
                $first,
                $operator,
                $second,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_column()
    {
        $criteria = Criteria::create()->orWhereColumn(
            $first = 'foo',
            $operator = '=',
            $second = 'bar'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereColumn',
            'parameters' => [
                $first,
                $operator,
                $second,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_raw()
    {
        $criteria = Criteria::create()->whereRaw(
            $sql = 'SELECT * FROM table',
            $bindings = ['foo', 'bar'],
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereRaw',
            'parameters' => [
                $sql,
                $bindings,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_raw()
    {
        $criteria = Criteria::create()->orWhereRaw(
            $sql = 'SELECT * FROM table',
            $bindings = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereRaw',
            'parameters' => [
                $sql,
                $bindings,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_in()
    {
        $criteria = Criteria::create()->whereIn(
            $column = 'foo',
            $values = ['foo', 'bar'],
            $boolean = 'or',
            $not = true
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereIn',
            'parameters' => [
                $column,
                $values,
                $boolean,
                $not,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_in()
    {
        $criteria = Criteria::create()->orWhereIn(
            $column = 'foo',
            $values = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereIn',
            'parameters' => [
                $column,
                $values,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_not_in()
    {
        $criteria = Criteria::create()->whereNotIn(
            $column = 'foo',
            $values = ['foo', 'bar'],
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereNotIn',
            'parameters' => [
                $column,
                $values,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_not_in()
    {
        $criteria = Criteria::create()->orWhereNotIn(
            $column = 'foo',
            $values = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereNotIn',
            'parameters' => [
                $column,
                $values,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_null()
    {
        $criteria = Criteria::create()->whereNull(
            $column = 'foo',
            $boolean = 'or',
            $not = true
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereNull',
            'parameters' => [
                $column,
                $boolean,
                $not,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_null()
    {
        $criteria = Criteria::create()->orWhereNull(
            $column = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereNull',
            'parameters' => [
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_not_null()
    {
        $criteria = Criteria::create()->whereNotNull(
            $column = 'foo',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereNotNull',
            'parameters' => [
                $column,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_between()
    {
        $criteria = Criteria::create()->whereBetween(
            $column = 'foo',
            $values = ['foo', 'bar'],
            $boolean = 'or',
            $not = true
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereBetween',
            'parameters' => [
                $column,
                $values,
                $boolean,
                $not,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_between()
    {
        $criteria = Criteria::create()->orWhereBetween(
            $column = 'foo',
            $values = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereBetween',
            'parameters' => [
                $column,
                $values,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_not_between()
    {
        $criteria = Criteria::create()->whereNotBetween(
            $column = 'foo',
            $values = ['foo', 'bar'],
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereNotBetween',
            'parameters' => [
                $column,
                $values,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_not_between()
    {
        $criteria = Criteria::create()->orWhereNotBetween(
            $column = 'foo',
            $values = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereNotBetween',
            'parameters' => [
                $column,
                $values,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_not_null()
    {
        $criteria = Criteria::create()->orWhereNotNull(
            $column = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereNotNull',
            'parameters' => [
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_date()
    {
        $criteria = Criteria::create()->whereDate(
            $column = 'foo',
            $operator = '=',
            $value = '20170721',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereDate',
            'parameters' => [
                $column,
                $operator,
                $value,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_date()
    {
        $criteria = Criteria::create()->orWhereDate(
            $column = 'foo',
            $operator = '=',
            $value = '20170721'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereDate',
            'parameters' => [
                $column,
                $operator,
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_time()
    {
        $criteria = Criteria::create()->whereTime(
            $column = 'foo',
            $operator = '=',
            $value = '11:11:11',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereTime',
            'parameters' => [
                $column,
                $operator,
                $value,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_time()
    {
        $criteria = Criteria::create()->orWhereTime(
            $column = 'foo',
            $operator = '=',
            $value = '11:11:11'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereTime',
            'parameters' => [
                $column,
                $operator,
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_day()
    {
        $criteria = Criteria::create()->whereDay(
            $column = 'foo',
            $operator = '=',
            $value = '01',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereDay',
            'parameters' => [
                $column,
                $operator,
                $value,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_month()
    {
        $criteria = Criteria::create()->whereMonth(
            $column = 'foo',
            $operator = '=',
            $value = '01',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereMonth',
            'parameters' => [
                $column,
                $operator,
                $value,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_year()
    {
        $criteria = Criteria::create()->whereYear(
            $column = 'foo',
            $operator = '=',
            $value = '01',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereYear',
            'parameters' => [
                $column,
                $operator,
                $value,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_nested()
    {
        $criteria = Criteria::create()->whereNested(
            $callback = function () {
            },
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereNested',
            'parameters' => [
                $callback,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_add_nested_where_query()
    {
        $criteria = Criteria::create()->addNestedWhereQuery(
            $query = m::mock('Illuminate\Database\Query\Builder'),
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'addNestedWhereQuery',
            'parameters' => [
                $query,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_exists()
    {
        $criteria = Criteria::create()->whereExists(
            $callback = function () {
            },
            $boolean = 'or',
            $not = true
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereExists',
            'parameters' => [
                $callback,
                $boolean,
                $not,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_exists()
    {
        $criteria = Criteria::create()->orWhereExists(
            $callback = function () {
            },
            $not = true
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereExists',
            'parameters' => [
                $callback,
                $not,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_where_not_exists()
    {
        $criteria = Criteria::create()->whereNotExists(
            $callback = function () {
            },
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'whereNotExists',
            'parameters' => [
                $callback,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_where_not_exists()
    {
        $criteria = Criteria::create()->orWhereNotExists(
            $callback = function () {
            }
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orWhereNotExists',
            'parameters' => [
                $callback,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_add_where_exists_query()
    {
        $criteria = Criteria::create()->addWhereExistsQuery(
            $query = m::mock('Illuminate\Database\Query\Builder'),
            $boolean = 'or',
            $not = true
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'addWhereExistsQuery',
            'parameters' => [
                $query,
                $boolean,
                $not,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_dynamic_where()
    {
        $criteria = Criteria::create()->dynamicWhere(
            $method = m::mock('Illuminate\Database\Query\Builder'),
            $parameters = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'dynamicWhere',
            'parameters' => [
                $method,
                $parameters,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_group_by()
    {
        $criteria = Criteria::create()->groupBy(
            $group = 'a',
            $group2 = 'b',
            $group3 = 'c'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'groupBy',
            'parameters' => [
                $group,
                $group2,
                $group3,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_having()
    {
        $criteria = Criteria::create()->having(
            $column = 'foo',
            $operator = '=',
            $value = 'bar',
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'having',
            'parameters' => [
                $column,
                $operator,
                $value,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_having()
    {
        $criteria = Criteria::create()->orHaving(
            $column = 'foo',
            $operator = '=',
            $value = 'bar'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orHaving',
            'parameters' => [
                $column,
                $operator,
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_having_raw()
    {
        $criteria = Criteria::create()->havingRaw(
            $sql = 'SELECT * FROM ? = ?',
            $bindings = ['foo', 'bar'],
            $boolean = 'or'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'havingRaw',
            'parameters' => [
                $sql,
                $bindings,
                $boolean,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_or_having_raw()
    {
        $criteria = Criteria::create()->orHavingRaw(
            $sql = 'SELECT * FROM ? = ?',
            $bindings = ['foo', 'bar']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orHavingRaw',
            'parameters' => [
                $sql,
                $bindings,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_order_by()
    {
        $criteria = Criteria::create()->orderBy(
            $column = 'foo',
            $direction = 'desc'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orderBy',
            'parameters' => [
                $column,
                $direction,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_order_desc()
    {
        $criteria = Criteria::create()->orderByDesc(
            $column = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orderByDesc',
            'parameters' => [
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_latest()
    {
        $criteria = Criteria::create()->latest(
            $column = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'latest',
            'parameters' => [
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_oldest()
    {
        $criteria = Criteria::create()->oldest(
            $column = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'oldest',
            'parameters' => [
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_in_random_order()
    {
        $criteria = Criteria::create()->inRandomOrder(
            $column = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'inRandomOrder',
            'parameters' => [
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_order_by_raw()
    {
        $criteria = Criteria::create()->orderByRaw(
            $sql = 'ORDER BY ? DESC',
            $binding = ['foo']
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'orderByRaw',
            'parameters' => [
                $sql,
                $binding,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_skip()
    {
        $criteria = Criteria::create()->skip(
            $value = 5
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'skip',
            'parameters' => [
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_offset()
    {
        $criteria = Criteria::create()->offset(
            $value = 5
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'offset',
            'parameters' => [
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_take()
    {
        $criteria = Criteria::create()->take(
            $value = 5
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'take',
            'parameters' => [
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_limit()
    {
        $criteria = Criteria::create()->limit(
            $value = 5
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'limit',
            'parameters' => [
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_for_page()
    {
        $criteria = Criteria::create()->forPage(
            $page = 5,
            $perPage = 10
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'forPage',
            'parameters' => [
                $page,
                $perPage,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_for_page_after_id()
    {
        $criteria = Criteria::create()->forPageAfterId(
            $perPage = 10,
            $lastId = 1,
            $column = 'foo'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'forPageAfterId',
            'parameters' => [
                $perPage,
                $lastId,
                $column,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_union()
    {
        $criteria = Criteria::create()->union(
            $query = 'SELECT * FROM table',
            $all = true
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'union',
            'parameters' => [
                $query,
                $all,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_union_all()
    {
        $criteria = Criteria::create()->unionAll(
            $query = 'SELECT * FROM table'
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'unionAll',
            'parameters' => [
                $query,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testLock()
    {
        $criteria = Criteria::create()->lock(
            $value = false
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'lock',
            'parameters' => [
                $value,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_lock_for_update()
    {
        $criteria = Criteria::create()->lockForUpdate();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'lockForUpdate',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_shared_lock()
    {
        $criteria = Criteria::create()->sharedLock();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'sharedLock',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_when()
    {
        $criteria = Criteria::create()->when(
            $value = true,
            $callback = function () {
            },
            $default = function () {
            }
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'when',
            'parameters' => [
                $value,
                $callback,
                $default,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_unless()
    {
        $criteria = Criteria::create()->unless(
            $value = true,
            $callback = function () {
            },
            $default = function () {
            }
        );
        $this->assertSame($criteria->toArray(), [[
            'method' => 'unless',
            'parameters' => [
                $value,
                $callback,
                $default,
            ],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function test_use_write_pdo()
    {
        $criteria = Criteria::create()->useWritePdo();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'useWritePdo',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }
}
