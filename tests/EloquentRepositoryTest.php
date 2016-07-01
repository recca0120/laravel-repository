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

    public function test_repository_create()
    {
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('create')->with($data)->andReturnSelf()
            ->mock();

        $repository = new EloquentRepository($model);
        $result = $repository->create($data);
        $this->assertSame($result, $model);
    }

    public function test_repository_update()
    {
        $id = 1;
        $data = ['a' => 'b'];
        $model = m::mock(Model::class)
            ->shouldReceive('find')->with($id)->andReturnSelf()
            ->shouldReceive('fill')->with($data)->andReturnSelf()
            ->shouldReceive('save')
            ->mock();

        $repository = new EloquentRepository($model);
        $result = $repository->update($data, $id);
        $this->assertSame($result, $model);
    }

    public function test_repository_delete()
    {
        $id = 1;
        $model = m::mock(Model::class)
            ->shouldReceive('find')->with($id)->andReturnSelf()
            ->shouldReceive('delete')->andReturn(true)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertTrue($repository->delete($id));
    }

    public function test_repository_new_instance()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('forceFill')
            ->mock();
        $repository = new EloquentRepository($model);
        $repository->newInstance();
    }

    public function test_repository_find_by()
    {
        $data = [
            'a' => 'b',
        ];
        $model = m::mock(Model::class)
            ->shouldReceive('get')->andReturn($data)
            ->shouldReceive('take')->with(1)->andReturnSelf()
            ->shouldReceive('skip')->with(2)->andReturnSelf()
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->findBy([], 1, 2), $data);
    }

    public function test_repository_find_all()
    {
        $data = [
            'a' => 'b',
        ];
        $model = m::mock(Model::class)
            ->shouldReceive('get')->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->findAll(), $data);
    }

    public function test_repository_paginated_by()
    {
        $data = [
            'a' => 'b',
        ];
        $model = m::mock(Model::class)
            ->shouldReceive('paginate')->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->paginatedBy([], 1, 'page', null), $data);
    }

    public function test_repository_paginated_all()
    {
        $data = [
            'a' => 'b',
        ];
        $model = m::mock(Model::class)
            ->shouldReceive('paginate')->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->paginatedAll(1, 'page', null), $data);
    }

    public function test_repository_find_one_by()
    {
        $data = [
            'a' => 'b',
        ];
        $model = m::mock(Model::class)
            ->shouldReceive('first')->andReturn($data)
            ->mock();

        $repository = new EloquentRepository($model);
        $this->assertSame($repository->findOneBy([]), $data);
    }

    public function test_repository_find_by_criteria()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('id', '=', '1')->andReturnSelf()
            ->shouldReceive('where')->with(m::type(Closure::class))->andReturnSelf()
            ->shouldReceive('orWhere')->with('id', '=', '3')->andReturnSelf()
            ->shouldReceive('join')->with('table', m::type(Closure::class))->andReturnSelf()
            ->shouldReceive('select')->with('id')->andReturnSelf()
            ->shouldReceive('orderBy')->with('id', 'desc')->andReturnSelf()
            ->shouldReceive('groupBy')->with('id')->andReturnSelf()
            ->shouldReceive('having')->with('id', '=', m::type(Expression::class))->andReturnSelf()
            ->shouldReceive('with')->with('table')->andReturnSelf()
            ->shouldReceive('get')
            ->mock();

        $criteria = Criteria::create()
            ->select('id')
            ->where('id', '=', '1')
            ->where(function ($criteria) {
                return $criteria
                    ->where('id', '=', '2');
            })
            ->orWhere('id', '=', '3')
            ->join('table', function ($criteria) {
                return $criteria->on('m.id', '=', 't.id');
            })
            ->orderBy('id', 'desc')
            ->groupBy('id')
            ->having('id', '=', Criteria::expr('1'))
            ->with('table');

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_repository_find_by_multiple_criteria()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('id', '=', '1')->andReturnSelf()
            ->shouldReceive('where')->with(m::type(Closure::class))->andReturnSelf()
            ->shouldReceive('orWhere')->with('id', '=', '3')->andReturnSelf()
            ->shouldReceive('get')
            ->mock();

        $criteria = [
            Criteria::create()
                ->where('id', '=', '1'),
            Criteria::create()
                ->where(function ($criteria) {
                    return $criteria
                        ->where('id', '=', '2');
                }),
            Criteria::create()
                ->orWhere('id', '=', '3'),
        ];

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_repository_find_by_array()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('name', '=', '0001')->once()->andReturnSelf()
            ->shouldReceive('where')->with('email', '=', '0001@test.com')->once()->andReturnSelf()
            ->shouldReceive('where')->with('name', '0002')->once()->andReturnSelf()
            ->shouldReceive('where')->with('email', '0002@test.com')->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = [
            ['name', '=', '0001'],
            ['email', '=', '0001@test.com'],
            'name'  => '0002',
            'email' => '0002@test.com',
        ];

        $repository = new EloquentRepository($model);
        $repository->findBy($criteria);
    }

    public function test_repository_find_by_criteria_and_array()
    {
        $model = m::mock(Model::class)
            ->shouldReceive('where')->with('id', '=', '1')->andReturnSelf()
            ->shouldReceive('where')->with(m::type(Closure::class))->andReturnSelf()
            ->shouldReceive('orWhere')->with('id', '=', '3')->andReturnSelf()
            ->shouldReceive('where')->with('name', '=', '0001')->once()->andReturnSelf()
            ->shouldReceive('where')->with('email', '=', '0001@test.com')->once()->andReturnSelf()
            ->shouldReceive('where')->with('name', '0002')->once()->andReturnSelf()
            ->shouldReceive('where')->with('email', '0002@test.com')->once()->andReturnSelf()
            ->shouldReceive('get')->once()
            ->mock();

        $criteria = [
            Criteria::create()
                ->where('id', '=', '1'),
            Criteria::create()
                ->where(function ($criteria) {
                    return $criteria
                        ->where('id', '=', '2');
                }),
            Criteria::create()
                ->orWhere('id', '=', '3'),
            ['name', '=', '0001'],
            ['email', '=', '0001@test.com'],
            'name'  => '0002',
            'email' => '0002@test.com',
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
        Criteria::expr('test');
    }
}
