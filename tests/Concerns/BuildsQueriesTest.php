<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class BuildsQueriesTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testSelect()
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

    public function testSelectRaw()
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

    public function testSelectSub()
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

    public function testAddSelect()
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

    public function testDistinct()
    {
        $criteria = Criteria::create()->distinct();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'distinct',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testFrom()
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

    public function testJoin()
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

    public function testJoinWhere()
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

    public function testLeftJoin()
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

    public function testLeftJoinWhere()
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

    public function testRightJoin()
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

    public function testRightJoinWhere()
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

    public function testCrossJoin()
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

    public function testTap()
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

    public function testWhere()
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

    public function testOrWhere()
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

    public function testWhereColumn()
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

    public function testOrWhereColumn()
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

    public function testWhereRaw()
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

    public function testOrWhereRaw()
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

    public function testWhereIn()
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

    public function testOrWhereIn()
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

    public function testWhereNotIn()
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

    public function testOrWhereNotIn()
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

    public function testWhereNull()
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

    public function testOrWhereNull()
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

    public function testWhereNotNull()
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

    public function testWhereBetween()
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

    public function testOrWhereBetween()
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

    public function testWhereNotBetween()
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

    public function testOrWhereNotBetween()
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

    public function testOrWhereNotNull()
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

    public function testWhereDate()
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

    public function testOrWhereDate()
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

    public function testWhereTime()
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

    public function testOrWhereTime()
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

    public function testWhereDay()
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

    public function testWhereMonth()
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

    public function testWhereYear()
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

    public function testWhereNested()
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

    public function testAddNestedWhereQuery()
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

    public function testWhereExists()
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

    public function testOrWhereExists()
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

    public function testWhereNotExists()
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

    public function testOrWhereNotExists()
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

    public function testAddWhereExistsQuery()
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

    public function testDynamicWhere()
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

    public function testGroupBy()
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

    public function testHaving()
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

    public function testOrHaving()
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

    public function testHavingRaw()
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

    public function testOrHavingRaw()
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

    public function testOrderBy()
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

    public function testOrderDesc()
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

    public function testLatest()
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

    public function testOldest()
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

    public function testInRandomOrder()
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

    public function testOrderByRaw()
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

    public function testSkip()
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

    public function testOffset()
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

    public function testTake()
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

    public function testLimit()
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

    public function testforPage()
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

    public function testForPageAfterId()
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

    public function testUnion()
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

    public function testUnionAll()
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

    public function testLockForUpdate()
    {
        $criteria = Criteria::create()->lockForUpdate();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'lockForUpdate',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testSharedLock()
    {
        $criteria = Criteria::create()->sharedLock();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'sharedLock',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }

    public function testWhen()
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

    public function testUnless()
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

    public function testUseWritePdo()
    {
        $criteria = Criteria::create()->useWritePdo();
        $this->assertSame($criteria->toArray(), [[
            'method' => 'useWritePdo',
            'parameters' => [],
        ]]);
        $this->assertInstanceOf('Recca0120\Repository\Criteria', $criteria);
    }
}
