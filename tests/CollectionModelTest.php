<?php

namespace Recca0120\Repository\Tests;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Schema\Blueprint;
use Recca0120\Repository\CollectionModel;
use Recca0120\Repository\EloquentRepository;

class CollectionTest extends TestCase
{
    public function testFind()
    {
        $fakeModel = new FakeCollectionModel;
        $fakeRepository = new FakeCollectionRepository($fakeModel);

        $instance = $fakeRepository->find(1);
        $this->assertInstanceOf(FakeCollectionModel::class, $instance);
        $this->assertTrue($instance->exists);
    }
}

class FakeCollectionModel extends CollectionModel
{
    protected $items = [
        ['id' => 1, 'foo' => 'bar'],
    ];

    protected $fillable = [
        'foo',
    ];

    protected function createSchema(Blueprint $table)
    {
        $table->increments('id');
        $table->string('foo');
        $table->timestamps();
    }
}

class FakeCollectionRepository extends EloquentRepository
{
}
