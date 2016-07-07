<?php

use Illuminate\Support\Collection;
use Mockery as m;
use Recca0120\Repository\CollectionRepository;
use Recca0120\Repository\Criteria;

class CollectionRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function test_new_instance()
    {
        $collection = $this->getCollectionMock();

        $repository = new CollectionRepository($collection);
        $repository->newInstance();
    }

    public function test_create()
    {
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock();

        $repository = new CollectionRepository($collection);
        $repository->create($data);
        $result = $repository->create($data);
        // $this->assertSame($result, $model);
    }

    public function test_find()
    {
        $id = 1;
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock()
            ->shouldReceive('where')->with('id', $id)->andReturnSelf()
            ->shouldReceive('first')
            ->mock();

        $repository = new CollectionRepository($collection);
        $result = $repository->find($id);
        // $this->assertSame($result, $model);
    }

    public function test_update()
    {
        $id = 1;
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock();

        $repository = new CollectionRepository($collection);
        $result = $repository->update($data, $id);
        // $this->assertSame($result, $model);
    }

    public function test_delete()
    {
        $id = 1;
        $collection = $this->getCollectionMock();

        $repository = new CollectionRepository($collection);
        $result = $repository->delete($id);
        // $this->assertTrue($result);
    }

    public function test_find_by()
    {
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock()
            ->shouldReceive('take')->with(1)->once()->andReturnSelf()
            ->shouldReceive('skip')->with(2)->once()->andReturnSelf()
            ->shouldReceive('toArray')->once()->andReturn($data)
            ->mock();

        $repository = new CollectionRepository($collection);
        $this->assertSame($repository->findBy([], 1, 2)->toArray(), $data);
    }

    public function test_find_all()
    {
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock()
            ->shouldReceive('toArray')->once()->andReturn($data)
            ->mock();

        $repository = new CollectionRepository($collection);
        $this->assertSame($repository->findAll()->toArray(), $data);
    }

    public function test_paginated_by()
    {
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock()
            ->shouldReceive('count')->once()->andReturn(10)
            ->shouldReceive('forPage')->once()->andReturnSelf()
            ->shouldReceive('all')->once()->andReturn($data)
            ->mock();

        $repository = new CollectionRepository($collection);
        $this->assertSame($repository->paginatedBy([], 1, 'page', 1)->items(), $data);
    }

    public function test_paginated_all()
    {
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock()
            ->shouldReceive('count')->once()->andReturn(10)
            ->shouldReceive('forPage')->once()->andReturnSelf()
            ->shouldReceive('all')->once()->andReturn($data)
            ->mock();

        $repository = new CollectionRepository($collection);
        $this->assertSame($repository->paginatedAll(1, 'page', 1)->items(), $data);
    }

    public function test_find_one_by()
    {
        $data = ['a' => 'b'];
        $collection = $this->getCollectionMock()
            ->shouldReceive('first')->andReturn($data)
            ->mock();

        $repository = new CollectionRepository($collection);
        $this->assertSame($repository->findOneBy([]), $data);
    }

    public function test_find_by_criteria_where()
    {
        $collection = $this->getCollectionMock()
            ->shouldReceive('filter')->with(m::type(Closure::class))->once()->andReturnSelf()
            // ->shouldReceive('orWhere')->with('id', '=', 1)->once()->andReturnSelf()
            // ->shouldReceive('where')->with(m::type(Closure::class))->once()->andReturnSelf()
            ->mock();

        $criteria = Criteria::create()
            ->where('id', '=', 1);
            // ->orWhere('id', '=', 1)
            // ->where(function (Criteria $criteria) {
            //     return $criteria->where('id', '=', '1');
            // });

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_having()
    {
        $collection = $this->getCollectionMock()
            ->shouldReceive('filter')->with(m::type(Closure::class))->once()->andReturnSelf()
            // ->shouldReceive('orWhere')->with('id', '=', 1)->once()->andReturnSelf()
            // ->shouldReceive('where')->with(m::type(Closure::class))->once()->andReturnSelf()
            ->mock();

        $criteria = Criteria::create()
            ->having('id', '=', 1);
            // ->orHaving('id', '=', 1)
            // ->having(function (Criteria $criteria) {
            //     return $criteria->having('id', '=', '1');
            // })

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    //
    // public function test_find_by_criteria_group_by()
    // {
    //     $model = m::mock(Model::class)
    //         ->shouldReceive('groupBy')->with('id')->once()->andReturnSelf()
    //         ->shouldReceive('get')->once()
    //         ->mock();
    //
    //     $criteria = Criteria::create()
    //         ->groupBy('id');
    //
    //     $repository = new EloquentRepository($model);
    //     $repository->findBy($criteria);
    // }

    public function test_find_by_criteria_order_by()
    {
        $data = [
            ['id' => 1, 'name' => 'Pascal', 'age' => '15'],
            ['id' => 5, 'name' => 'Mark', 'age' => '25'],
            ['id' => 3, 'name' => 'Hugo', 'age' => '55'],
            ['id' => 2, 'name' => 'Angus', 'age' => '25'],
        ];

        $collection = $this->getCollectionMock()
            ->shouldReceive('sort')->with(m::type(Closure::class))->once()->andReturnUsing(function ($callback) use (&$data) {
                uasort($data, $callback);

                $this->assertEquals([
                    ['id' => 3, 'name' => 'Hugo', 'age' => '55'],
                    ['id' => 2, 'name' => 'Angus', 'age' => '25'],
                    ['id' => 5, 'name' => 'Mark', 'age' => '25'],
                    ['id' => 1, 'name' => 'Pascal', 'age' => '15'],
                ], array_values($data));
            })
            ->mock();

        $criteria = Criteria::create()
            ->orderBy('age', 'desc')
            ->orderBy('id', 'asc');

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_with()
    {
        $collection = $this->getCollectionMock();

        $criteria = Criteria::create()
            ->with('table')
            ->with('table2', function (Criteria $criteria) {
                return $criteria->where('id', '=', '1');
            });

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_join()
    {
        $collection = $this->getCollectionMock();

        $criteria = Criteria::create()
            ->join('table2', function (Criteria $criteria) {
                return $criteria->on('table1.id', '=', 'table2.id');
            });

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_select()
    {
        $collection = $this->getCollectionMock();

        $criteria = Criteria::create()
            ->select('id');

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    // public function test_find_by_criteria_select_expression()
    // {
    //     $model = m::mock(Model::class)
    //         ->shouldReceive('select')->with(m::type(Expression::class))->once()->andReturnSelf()
    //         ->shouldReceive('get')->once()
    //         ->mock();
    //
    //     $criteria = Criteria::create()
    //         ->select(Criteria::expr('id'));
    //
    //     $repository = new EloquentRepository($model);
    //     $repository->findBy($criteria);
    // }
    //
    public function test_find_by_array()
    {
        $collection = $this->getCollectionMock()
            ->shouldReceive('filter')->once()->andReturnSelf()
            ->shouldReceive('where')->with('id', 1)->once()->andReturnSelf()
            ->shouldReceive('where')->with('id', 2)->once()->andReturnSelf()
            ->mock();

        $criteria = [
            ['id', '=', 1],
            ['id', 1],
            'id' => 2,
        ];

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_find_by_criteria_and_array()
    {
        $collection = $this->getCollectionMock()
            ->shouldReceive('filter')->once()->andReturnSelf()
            ->shouldReceive('filter')->once()->andReturnSelf()
            ->mock();

        $criteria = [
            ['id', '=', 1],
            Criteria::create()
                ->where('id', '=', 2),
        ];

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    protected function getCollectionMock()
    {
        return m::mock(Collection::class)
            ->shouldReceive('make')->once()->andReturnSelf()
            ->shouldReceive('map')->andReturnSelf()
            ->mock();
    }
}
