<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;

class EloquentRepositoryTest extends TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testNewInstance()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('forceFill')->once();
        $repository->newInstance();
    }

    public function testCreate()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('forceFill')->once()->with([])->andReturnSelf();
        $model->shouldReceive('fill')->once()->with($data = ['foo' => 'bar'])->andReturnSelf();
        $model->shouldReceive('save')->once();
        $this->assertSame($model, $repository->create($data));
    }

    public function testCreateForceFill()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('forceFill')->once()->with([])->andReturnSelf();
        $model->shouldReceive('forceFill')->once()->with($data = ['foo' => 'bar'])->andReturnSelf();
        $model->shouldReceive('save')->once();
        $this->assertSame($model, $repository->create($data, true));
    }

    public function testFind()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('find')->with($id = 1)->once()->andReturnSelf();
        $this->assertSame($model, $repository->find($id));
    }

    public function testUpdate()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('find')->once()->with($id = 1)->andReturnSelf();
        $model->shouldReceive('fill')->once()->with($data = ['foo' => 'bar'])->andReturnSelf();
        $model->shouldReceive('save')->once();
        $this->assertSame($model, $repository->update($data, $id));
    }

    public function testUpdateForceFill()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('find')->once()->with($id = 1)->andReturnSelf();
        $model->shouldReceive('forceFill')->once()->with($data = ['foo' => 'bar'])->andReturnSelf();
        $model->shouldReceive('save')->once();
        $this->assertSame($model, $repository->update($data, $id, true));
    }

    public function testDelete()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('find')->once()->with($id = 1)->andReturnSelf();
        $model->shouldReceive('delete')->once()->andReturn(true);
        $this->assertTrue($repository->delete($id));
    }

    public function testGetByCriteria()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('take')->once()->with($take = 10)->andReturnSelf();
        $model->shouldReceive('skip')->once()->with($skip = 5)->andReturnSelf();
        $model->shouldReceive('get')->once()->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->get([], ['*'], $take, $skip));
    }

    public function testPaginateByCriteria()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('paginate')->once()->with(1, ['*'], 'page', 1)->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->paginate([], 1, ['*'], 'page', 1));
    }

    public function testSimplePaginateByCriteria()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('simplePaginate')->once()->with(1, ['*'], 'page', 1)->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->simplePaginate([], 1, ['*'], 'page', 1));
    }

    public function testChunkByCriteria()
    {
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);
        $model->shouldReceive('chunk')->with($count = 100, $callable = function () {
        })->once()->andReturn(true);
        $this->assertSame(true, $repository->chunk([], $count, $callable));
    }

    public function testCountByCriteria()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $criteria = Criteria::create()
            ->where('foo', '=', 'bar')
            ->orWhere('buzz', '=', 'fuzz')
            ->where(function (Criteria $criteria) {
                return $criteria->where('id', '=', 'closure');
            });
        $model->shouldReceive('where')->once()->with('foo', '=', 'bar')->andReturnSelf();
        $model->shouldReceive('orWhere')->once()->with('buzz', '=', 'fuzz')->andReturnSelf();
        $model->shouldReceive('where')->with(m::type('Closure'))->once()->andReturnUsing(function ($closure) {
            $tranform = $closure(m::self());

            return m::self();
        });
        $model->shouldReceive('where')->once()->with('id', '=', 'closure')->andReturnSelf();
        $model->shouldReceive('count')->once()->andReturn($excepted = 10);
        $this->assertSame($repository->count($criteria), $excepted);
    }

    public function testFirstByCriteria()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('first')->once()->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->first([]));
    }

    public function destroyByCriteria()
    {
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new EloquentRepository($model);
        $criteria = Criteria::create()
            ->where('foo', '=', 'bar')
            ->orWhere('buzz', '=', 'fuzz')
            ->where(function (Criteria $criteria) {
                return $criteria->where('id', '=', 'closure');
            });

        $model->shouldReceive('where')->once()->with('foo', '=', 'bar')->andReturnSelf();
        $model->shouldReceive('orWhere')->once()->with('buzz', '=', 'fuzz')->andReturnSelf();
        $model->shouldReceive('where')->once()->with(m::type('Closure'))->andReturnUsing(function ($closure) {
            $tranform = $closure(m::self());

            return m::self();
        });
        $model->shouldReceive('where')->with('id', '=', 'closure')->once()->andReturnSelf();
        $model->shouldReceive('delete')->once()->andReturn($excepted = 10);
        $this->assertSame($repository->destroy($criteria), $excepted);
    }

    public function testCustomCriteria()
    {
        $repository = new EloquentRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('where')->once()->with('foo', '=', 'bar')->andReturnSelf();
        $model->shouldReceive('where')->once()->with('fuzz', '=', 'buzz')->andReturnSelf();
        $model->shouldReceive('get')->once();
        $repository->get([
            CustomEloquentCriteria::create('foo', 'bar'),
            (new CustomEloquentCriteria('fuzz', 'buzz')),
        ]);
    }
}

class CustomEloquentCriteria extends Criteria
{
    public function __construct($a, $b)
    {
        $this->where($a, '=', $b);
    }
}
