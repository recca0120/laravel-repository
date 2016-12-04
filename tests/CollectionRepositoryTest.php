<?php

use Mockery as m;
use Illuminate\Support\Fluent;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\CollectionRepository;

class CollectionRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    protected function mockCollection($data = [])
    {
        return m::mock('Illuminate\Support\Collection')
            ->shouldReceive('make')->once()->andReturnSelf()
            ->shouldReceive('map')->andReturnUsing(function ($closure) use ($data) {
                $closure($data);

                return m::self();
            })
            ->shouldReceive('keyBy')->andReturnSelf()
            ->mock();
    }

    public function test_new_instance()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

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
        $model = $this->mockCollection($data);
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('push')->once()->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame((new Fluent($data))->toArray(), $repository->create($data)->toArray());
    }

    public function test_find()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('get')->with($id)->andReturnSelf();

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
        $model = $this->mockCollection($data);
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('get')->with($id)->andReturnSelf()
            ->shouldReceive('put')->andReturnSelf();

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($model, $repository->update($data, $id));
    }

    public function test_delete()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $id = 1;
        $model = $this->mockCollection();
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('forget')->with($id)
            ->shouldReceive('has')->andReturn(true);

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
        $model = $this->mockCollection($data);
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('take')->with(10)->once()->andReturnSelf()
            ->shouldReceive('skip')->with(5)->once()->andReturnSelf()
            ->shouldReceive('toArray')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->get([], ['*'], 10, 5)->toArray());
    }

    public function test_paginate_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection($data);
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model
            ->shouldReceive('count')->once()->andReturn(10)
            ->shouldReceive('forPage')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->paginate([], 1, ['*'], 'page', 1)->items());
    }

    public function test_simple_paginate_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection($data);
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $model->shouldReceive('forPage')->once()->andReturn($data);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        $this->assertSame($data, $repository->simplePaginate([], 1, ['*'], 'page', 1)->items());
    }

    public function test_first_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection($data);
        $repository = new CollectionRepository($model);

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

    public function test_destroy_by_criteria()
    {
        /*
        |------------------------------------------------------------
        | Set
        |------------------------------------------------------------
        */

        $data = ['foo' => 'bar'];
        $model = $this->mockCollection($data);
        $repository = new CollectionRepository($model);

        /*
        |------------------------------------------------------------
        | Expectation
        |------------------------------------------------------------
        */

        $excepted = 1;
        $criteria = Criteria::create()
            ->where('id', '=', 1);

        /*
        |------------------------------------------------------------
        | Assertion
        |------------------------------------------------------------
        */

        // $this->assertSame($repository->destroy($criteria), $excepted);
        $repository->destroy($criteria);
    }
}
