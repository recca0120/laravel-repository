<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\Compilers\EloquentCompiler;

class EloquentTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function test_where_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->where('foo', '=', 'bar')
            ->orWhere('buzz', '=', 'fuzz')
            ->where(function (Criteria $criteria) {
                return $criteria->where('id', '=', 'closure');
            });

        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('orWhere')->with('buzz', '=', 'fuzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with(m::type('Closure'))->once()->andReturnUsing(function ($closure) {
                $compiler = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('where')->with('id', '=', 'closure')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_having_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->having('foo', '=', 'bar')
            ->orHaving('buzz', '=', 'fuzz')
            ->having(function (Criteria $criteria) {
                return $criteria->having('id', '=', 'closure');
            });

        $model
            ->shouldReceive('having')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('orHaving')->with('buzz', '=', 'fuzz')->once()->andReturnSelf()
            ->shouldReceive('having')->with(m::type('Closure'))->once()->andReturnUsing(function ($closure) {
                $compiler = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('having')->with('id', '=', 'closure')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_group_by_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->groupBy('id');

        $model
            ->shouldReceive('groupBy')->with('id')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_order_by_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->orderBy('id');

        $model
            ->shouldReceive('orderBy')->with('id')->once()->andReturnSelf();
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_join_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->join('table2', function (Criteria $criteria) {
                return $criteria->on('table1.id', '=', 'table2.id');
            });

        $model
            ->shouldReceive('join')->with('table2', m::type('Closure'))->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_with_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->with('table')
            ->with('table2', function (Criteria $criteria) {
                return $criteria->where('id', '=', 'closure');
            });

        $model
            ->shouldReceive('with')->with('table')->once()->andReturnSelf()
            ->shouldReceive('with')->with('table2', m::type('Closure'))->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_select_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->select('id');

        $model
            ->shouldReceive('select')->with('id')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_select_expression_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = Criteria::create()
            ->select(Criteria::expr('id'));

        $model
            ->shouldReceive('select')->with(m::type('Illuminate\Database\Query\Expression'))->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_array_where_condition()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = [
            ['foo', '=', 'bar'],
            ['fuzz', 'buzz'],
            'hello' => 'world',
        ];

        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', 'buzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with('hello', 'world')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }

    public function test_criteria_and_array()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $compiler = new EloquentCompiler($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $criteria = [
            ['foo', '=', 'bar'],
            Criteria::create()
                ->where('fuzz', '=', 'buzz'),
        ];

        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', '=', 'buzz')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $compiler->push($criteria)->apply());
    }
}
