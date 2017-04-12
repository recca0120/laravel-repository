<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use Illuminate\Support\Fluent;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\Criteria;
use Recca0120\Repository\CollectionRepository;

class CollectionRepositoryTest extends TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testNewInstance()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection()
        );
        $this->isInstanceOf('Illuminate\Support\Fluent', $repository->newInstance());
    }

    public function testCreate()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection($data = ['foo' => 'bar'])
        );
        $model->shouldReceive('push')->once()->andReturnSelf();
        $this->assertSame((new Fluent($data))->toArray(), $repository->create($data)->toArray());
    }

    public function testFind()
    {
        $id = 1;
        $repository = new CollectionRepository(
            $model = $this->mockCollection()
        );
        $model->shouldReceive('get')->with($id)->andReturnSelf();
        $this->assertSame($model, $repository->find($id));
    }

    public function testUpdate()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection($data = ['foo' => 'bar'])
        );
        $model->shouldReceive('get')->with($id = 1)->andReturnSelf();
        $model->shouldReceive('put')->andReturnSelf();
        $this->assertSame($model, $repository->update($data, $id));
    }

    public function testDelete()
    {
        $id = 1;
        $repository = new CollectionRepository(
            $model = $this->mockCollection()
        );
        $model->shouldReceive('forget')->with($id);
        $model->shouldReceive('has')->andReturn(true);
        $this->assertTrue($repository->delete($id));
    }

    public function testGet()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection($data = ['foo' => 'bar'])
        );
        $model->shouldReceive('take')->once()->with($take = 10)->andReturnSelf();
        $model->shouldReceive('skip')->once()->with($skip = 5)->andReturnSelf();
        $model->shouldReceive('toArray')->once()->andReturn($data);
        $this->assertSame($data, $repository->get([], ['*'], $take, $skip)->toArray());
    }

    public function testPaginate()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection($data = ['foo' => 'bar'])
        );

        $model->shouldReceive('count')->once()->andReturn(10);
        $model->shouldReceive('forPage')->once()->andReturn($data);

        $this->assertSame($data, $repository->paginate([], 1, ['*'], 'page', 1)->items());
    }

    public function testSimplePaginate()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection($data = ['foo' => 'bar'])
        );
        $model->shouldReceive('forPage')->once()->andReturn($data);
        $this->assertSame($data, $repository->simplePaginate([], 1, ['*'], 'page', 1)->items());
    }

    public function testFirst()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection($data = ['foo' => 'bar'])
        );
        $model->shouldReceive('first')->once()->andReturn($data);
        $this->assertSame($data, $repository->first([]));
    }

    public function testDestroy()
    {
        $repository = new CollectionRepository(
            $model = $this->mockCollection($data = ['foo' => 'bar'])
        );
        $criteria = Criteria::create()->where('id', '=', 1);
        $excepted = 1;
        // $this->assertSame($repository->destroy($criteria), $excepted);
        $repository->destroy($criteria);
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
}
