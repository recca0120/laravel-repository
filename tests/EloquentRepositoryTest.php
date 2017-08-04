<?php

namespace Recca0120\Repository\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Recca0120\Repository\EloquentRepository;

class EloquentRepositoryTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testInstance()
    {
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new Repository($model);
        $this->assertInstanceOf('Recca0120\Repository\EloquentRepository', $repository);
    }

    public function testNewInstance() {
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new Repository($model);
        $model->shouldReceive('forceFill')->once()->with(
            $attributes = ['foo' => 'bar']
        )->andReturnSelf();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $repository->newInstance($attributes));
    }

    public function testCreate()
    {
        $model = m::mock('Illuminate\Database\Eloquent\Model');
        $repository = new Repository($model);
        $model->shouldReceive('create')->once()->with(
            $attributes = ['foo' => 'bar']
        )->andReturnSelf();
        $repository->create($attributes);
    }
}

class Repository extends EloquentRepository {}
