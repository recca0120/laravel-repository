<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;

class EloquentRepositoryTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_new_instance()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('forceFill')->once();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $repository->newInstance();
    }

    public function test_create()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('forceFill')->with([])->once()->andReturnSelf()
            ->shouldReceive('fill')->with($data)->once()->andReturnSelf()
            ->shouldReceive('save')->once(true);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->create($data));
    }

    public function test_create_force_fill()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('forceFill')->with([])->once()->andReturnSelf()
            ->shouldReceive('forceFill')->with($data)->once()->andReturnSelf()
            ->shouldReceive('save')->once(true);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->create($data, true));
    }

    public function test_find()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('find')->with($id)->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->find($id));
    }

    public function test_update()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->shouldReceive('fill')->with($data)->once()->andReturnSelf()
            ->shouldReceive('save')->once();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->update($data, $id));
    }

    public function test_update_force_fill()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->shouldReceive('forceFill')->with($data)->once()->andReturnSelf()
            ->shouldReceive('save')->once();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->update($data, $id, true));
    }

    public function test_delete()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->shouldReceive('delete')->once()->andReturn(true);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertTrue($repository->delete($id));
    }

    public function test_get_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('take')->once()->with(10)->andReturnSelf()
            ->shouldReceive('skip')->once()->with(5)->andReturnSelf()
            ->shouldReceive('get')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->get([], ['*'], 10, 5));
    }

    public function test_paginate_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('paginate')->with(1, ['*'], 'page', 1)->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->paginate([], 1, ['*'], 'page', 1));
    }

    public function test_simple_paginate_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('simplePaginate')->with(1, ['*'], 'page', 1)->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->simplePaginate([], 1, ['*'], 'page', 1));
    }

    public function test_chunk_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);
        $callable = function () {
        };
        $count = 100;

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('chunk')->with($count, $callable)->once()->andReturn(true);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame(true, $repository->chunk([], $count, $callable));
    }

    public function test_count_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

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

        $excepted = 10;
        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('orWhere')->with('buzz', '=', 'fuzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with(m::type('Closure'))->once()->andReturnUsing(function ($closure) {
                $tranform = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('where')->with('id', '=', 'closure')->once()->andReturnSelf()
            ->shouldReceive('count')->once()->andReturn($excepted);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($repository->count($criteria), $excepted);
    }

    public function test_first_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('first')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->first([]));
    }

    public function destroy_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);

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

        $excepted = 10;
        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('orWhere')->with('buzz', '=', 'fuzz')->once()->andReturnSelf()
            ->shouldReceive('where')->with(m::type('Closure'))->once()->andReturnUsing(function ($closure) {
                $tranform = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('where')->with('id', '=', 'closure')->once()->andReturnSelf()
            ->shouldReceive('delete')->once()->andReturn($excepted);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($repository->destroy($criteria), $excepted);
    }

    public function test_custom_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);
        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */
        $model
            ->shouldReceive('where')->with('foo', '=', 'bar')->once()->andReturnSelf()
            ->shouldReceive('where')->with('fuzz', '=', 'buzz')->once()->andReturnSelf()
            ->shouldReceive('get')->once();
        $repository->get([
            CustomEloquentCriteria::create('foo', 'bar'),
            (new CustomEloquentCriteria('fuzz', 'buzz')),
        ]);
        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */
    }
}

class CustomEloquentCriteria extends Criteria
{
    public function __construct($a, $b)
    {
        $this->where($a, '=', $b);
    }
}
