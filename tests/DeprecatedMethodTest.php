<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\DeprecatedMethod;
use Recca0120\Repository\EloquentRepository;

class DeprecatedMethodTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testFindBy()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('take')->once()->with(10)->andReturnSelf();
        $model->shouldReceive('skip')->once()->with(5)->andReturnSelf();
        $model->shouldReceive('get')->once()->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->findBy([], 10, 5));
    }

    public function testFindAll()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('get')->once()->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->findAll());
    }

    public function testPaginatedBy()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('paginate')->once()->with(1, ['*'], 'page', 1)->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->paginatedBy([], 1, 'page', 1));
    }

    public function testPaginatedAll()
    {
        $data = ['foo' => 'bar'];
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('paginate')->with(1, ['*'], 'page', 1)->andReturn($data);
        $this->assertSame($data, $repository->paginatedAll(1, 'page', 1));
    }

    public function testChunkBy()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('chunk')->once()->with($count = 100, $callable = function () {
        })->andReturn(true);
        $this->assertSame(true, $repository->chunkBy([], $count, $callable));
    }

    public function testCountAll()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('count')->once()->andReturn($excepted = 10);
        $this->assertSame($repository->countBy([]), $excepted);
    }

    public function testFindOneBy()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('first')->once()->andReturn($data = ['foo' => 'bar']);
        $this->assertSame($data, $repository->findOneBy([]));
    }

    public function testMatching()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $repository->matching([]));
    }

    public function testFactory()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $model->shouldReceive('forceFill')->once()->with([])->andReturnSelf();
        $this->assertSame($model, $repository->factory([]));
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testDeprecated()
    {
        $repository = new DeprecatedRepository(
            $model = m::mock('Illuminate\Database\Eloquent\Model')
        );
        $repository->disableDeprecated()->factory([]);
    }
}

class DeprecatedRepository extends EloquentRepository
{
    use DeprecatedMethod;

    protected $disableDeprecated = false;

    public function disableDeprecated()
    {
        $this->disableDeprecated = true;

        return $this;
    }
}
