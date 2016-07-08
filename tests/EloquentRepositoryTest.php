<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;
use Mockery as m;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\EloquentRepository;

class EloquentRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_new_instance()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('forceFill')->once()
            ->mock();
        $repository = new EloquentRepository($model);
        $repository->newInstance();
    }

    public function test_create()
    {
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('create')->with($data)->once()->andReturnSelf()
            ->mock();

        $repository = new EloquentRepository($model);
        $result = $repository->create($data);
        $this->assertSame($result, $model);
    }

    public function test_find()
    {
        $id = 1;
        $model = m::mock(Model::class)
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->mock();

        $repository = new EloquentRepository($model);
        $repository->find($id);
    }

    public function test_update()
    {
        $id = 1;
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->shouldReceive('fill')->with($data)->once()->andReturnSelf()
            ->shouldReceive('save')->once()
            ->mock();

        $repository = new EloquentRepository($model);
        $result = $repository->update($data, $id);
        $this->assertSame($result, $model);
    }

    public function test_delete()
    {
        $id = 1;
        $model = m::mock(Model::class)
            ->shouldReceive('find')->with($id)->once()->andReturnSelf()
            ->shouldReceive('delete')->once()->andReturn(true)
            ->mock();

        $repository = new EloquentRepository($model);
        $result = $repository->delete($id);
        $this->assertTrue($result);
    }

    public function test_find_by()
    {
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('take')->once()->with(1)->andReturnSelf()
            ->shouldReceive('skip')->once()->with(2)->andReturnSelf()
            ->shouldReceive('get')->once()->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->findBy([], 1, 2), $data);
    }

    public function test_find_all()
    {
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('get')->once()->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->findAll(), $data);
    }

    public function test_paginated_by()
    {
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('paginate')->with(1, ['*'], 'page', 1)->once()->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->paginatedBy([], 1, 'page', 1), $data);
    }

    public function test_paginated_all()
    {
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('paginate')->with(1, ['*'], 'page', 1)->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->paginatedAll(1, 'page', 1), $data);
    }

    public function test_find_one_by()
    {
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('first')->once()->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->findOneBy([]), $data);
    }

    public function test_find_by_criteria_where()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('id', '=', 1)->once()->andReturnSelf()
            ->shouldReceive('orWhere')->with('id', '=', 1)->once()->andReturnSelf()
            ->shouldReceive('where')->with(m::type(Closure::class))->once()->andReturnUsing(function ($closure) {
                $tranform = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('where')->with('id', '=', 'closure')->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->where('id', '=', 1)
            ->orWhere('id', '=', 1)
            ->where(function (Criteria $criteria) {
                return $criteria->where('id', '=', 'closure');
            });

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_having()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('having')->with('id', '=', 1)->once()->andReturnSelf()
            ->shouldReceive('orHaving')->with('id', '=', 1)->once()->andReturnSelf()
            ->shouldReceive('having')->with(m::type(Closure::class))->once()->andReturnUsing(function ($closure) {
                $tranform = $closure(m::self());

                return m::self();
            })
            ->shouldReceive('having')->with('id', '=', 'closure')->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->having('id', '=', 1)
            ->orHaving('id', '=', 1)
            ->having(function (Criteria $criteria) {
                return $criteria->having('id', '=', 'closure');
            });

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_group_by()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('groupBy')->with('id')->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->groupBy('id');

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_order_by()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('orderBy')->with('id', 'asc')->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->orderBy('id', 'asc');

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_with()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('with')->with('table')->once()->andReturnSelf()
            ->shouldReceive('with')->with('table2', m::type(Closure::class))->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->with('table')
            ->with('table2', function (Criteria $criteria) {
                return $criteria->where('id', '=', '1');
            });

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_join()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('join')->with('table2', m::type(Closure::class))->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->join('table2', function (Criteria $criteria) {
                return $criteria->on('table1.id', '=', 'table2.id');
            });

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_select()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('select')->with('id')->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->select('id');

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_select_expression()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('select')->with(m::type(Expression::class))->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = Criteria::create()
            ->select(Criteria::expr('id'));

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_array()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('id', '=', 1)->once()->andReturnSelf()
            ->shouldReceive('where')->with('id', 1)->once()->andReturnSelf()
            ->shouldReceive('where')->with('id', 2)->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = [
            ['id', '=', 1],
            ['id', 1],
            'id' => 2,
        ];

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_and_array()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('id', '=', 1)->once()->andReturnSelf()
            ->shouldReceive('where')->with('id', '=', 2)->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = [
            ['id', '=', 1],
            Criteria::create()
                ->where('id', '=', 2),
        ];

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function test_call_undefined_criteria()
    {
        $criteria = new Criteria();
        $criteria->test();
    }

    public function test_echo_criteria_expression()
    {
        (string) Criteria::expr('test');
    }

    public function test_custom_criteria()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('id', '=', 1)->once()->andReturnSelf()
            ->shouldReceive('where')->with('id', '=', 2)->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $repository = new EloquentRepository($model);
        $repository->findBy([
            CustomCriteria::create(1),
            (new CustomCriteria(2)),
        ]);
    }

    public function test_criteria_arguments()
    {
        CustomCriteria::create(1);
        CustomCriteria::create(1, 2);
        CustomCriteria::create(1, 2, 3);
        CustomCriteria::create(1, 2, 3, 4);
        CustomCriteria::create(1, 2, 3, 4, 5);
    }
}

class CustomCriteria extends Criteria
{
    public function __construct($id)
    {
        $this->where('id', '=', $id);
    }
}
