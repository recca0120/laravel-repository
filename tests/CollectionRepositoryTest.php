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

    public function test_repository_find()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('where')->andReturnSelf()
            ->shouldReceive('first')->andReturnSelf()
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->find(1);
    }

    public function test_repository_create()
    {
        $data = ['a' => 'b'];

        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->create($data);
    }

    public function test_repository_update()
    {
        $id = 1;
        $data = ['a' => 'b'];
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->update($data, $id);
    }

    public function test_repository_delete()
    {
        $id = 1;
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->delete($id);
    }

    public function test_repository_new_instance()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->newInstance();
    }

    public function test_repository_find_by()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('take')->with(1)->andReturnSelf()
            ->shouldReceive('skip')->with(2)->andReturnSelf()
            ->mock();

        $repository = new CollectionRepository($collection);
        $this->assertSame($repository->findBy([], 1, 2), $collection);
    }

    public function test_repository_find_all()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->findAll();
    }

    public function test_repository_paginated_by()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('count')->andReturn(0)
            ->shouldReceive('forPage')->andReturn([])
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->paginatedBy([], 1, 'page', null);
    }

    public function test_repository_paginated_all()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('count')->andReturn(0)
            ->shouldReceive('forPage')->andReturn([])
            ->mock();

        $repository = new CollectionRepository($collection);
        $repository->paginatedAll(1, 'page', null);
    }
    //
    public function test_repository_find_one_by()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('first')->andReturn('a')
            ->mock();

        $repository = new CollectionRepository($collection);
        $this->assertSame('a', $repository->findOneBy([]));
    }

    public function test_repository_find_by_criteria()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('filter')->andReturnUsing(function ($closure) {
                $item = [
                    'id' => '1',
                ];
                $this->assertTrue($closure($item));
            })
            ->mock();

        $criteria = Criteria::create()
            ->where('id', '=', '1');

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_repository_find_by_criteria2()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('where')->andReturnSelf()
            ->mock();

        $criteria = Criteria::create()
            ->select('*')
            ->where('id', Criteria::expr('1'));

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_repository_find_by_multiple_criteria()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('filter')->andReturnSelf()->once()
            ->shouldReceive('where')->andReturnSelf()->once()
            ->mock();

        $criteria = [
            Criteria::create()
                ->where('id', '=', '1'),
            Criteria::create()
                ->Where('id', '3'),
        ];

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }

    public function test_repository_find_by_array()
    {
        $collection = m::mock(Collection::class)
            ->shouldReceive('make')->andReturnSelf()
            ->shouldReceive('filter')->andReturnSelf()->once()
            ->shouldReceive('where')->andReturnSelf()->once()
            ->mock();

        $criteria = [
            ['id', '=', '1'],
            ['id', '3'],
        ];

        $repository = new CollectionRepository($collection);
        $repository->findBy($criteria);
    }
    //
    // /**
    //  * @expectedException BadMethodCallException
    //  */
    // public function test_call_undefined_criteria()
    // {
    //     $criteria = new Criteria();
    //     $criteria->test();
    // }
}
