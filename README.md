# Repository Design Pattern for Laravel

[![StyleCI](https://styleci.io/repos/60332194/shield?style=flat)](https://styleci.io/repos/60332194)
[![Build Status](https://travis-ci.org/recca0120/laravel-repository.svg)](https://travis-ci.org/recca0120/laravel-repository)
[![Total Downloads](https://poser.pugx.org/recca0120/repository/d/total.svg)](https://packagist.org/packages/recca0120/repository)
[![Latest Stable Version](https://poser.pugx.org/recca0120/repository/v/stable.svg)](https://packagist.org/packages/recca0120/repository)
[![Latest Unstable Version](https://poser.pugx.org/recca0120/repository/v/unstable.svg)](https://packagist.org/packages/recca0120/repository)
[![License](https://poser.pugx.org/recca0120/repository/license.svg)](https://packagist.org/packages/recca0120/repository)
[![Monthly Downloads](https://poser.pugx.org/recca0120/repository/d/monthly)](https://packagist.org/packages/recca0120/repository)
[![Daily Downloads](https://poser.pugx.org/recca0120/repository/d/daily)](https://packagist.org/packages/recca0120/repository)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/recca0120/laravel-repository/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/recca0120/laravel-repository/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/recca0120/laravel-repository/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/recca0120/laravel-repository/?branch=master)

## Install

To get the latest version of Laravel Exceptions, simply require the project using [Composer](https://getcomposer.org):

```bash
composer require recca0120/repository
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "recca0120/repository": "~2.0.0"
    }
}
```

## Methods

### Recca0120\Repository\EloquentRepository

- find($id, $columns = ['*']);
- findMany($ids, $columns = ['*']);
- findOrFail($id, $columns = ['*']);
- findOrNew($id, $columns = ['*']);
- firstOrNew(array $attributes, array $values = []);
- firstOrCreate(array $attributes, array $values = []);
- updateOrCreate(array $attributes, array $values = []);
- firstOrFail($criteria = [], $columns = ['*']);
- create($attributes);
- forceCreate($attributes);
- update($id, $attributes);
- forceUpdate($id, $attributes);
- delete($id);
- forceDelete($id);
- newInstance($attributes = [], $exists = false);
- get($criteria = [], $columns = ['*']);
- chunk($criteria, $count, callable $callback);
- each($criteria, callable $callback, $count = 1000);
- first($criteria = [], $columns = ['*']);
- paginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);
- simplePaginate($criteria = [], $perPage = null, $columns = ['*'], $pageName = 'page', $page = null);
- count($criteria = [], $columns = '*');
- min($criteria, $column);
- max($criteria, $column);
- sum($criteria, $column);
- avg($criteria, $column);
- average($criteria, $column);
- matching($criteria);
- getQuery($criteria = []);
- getModel();
- newQuery();

### Recca0120\Repository\Criteria

- static create()
- static expr($value)
- static raw($value)
- select($columns = ['*'])
- selectRaw($expression, array $bindings = [])
- selectSub($query, $as)
- addSelect($column)
- distinct()
- from($table)
- join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
- joinWhere($table, $first, $operator, $second, $type = 'inner')
- leftJoin($table, $first, $operator = null, $second = null)
- leftJoinWhere($table, $first, $operator, $second)
- rightJoin($table, $first, $operator = null, $second = null)
- rightJoinWhere($table, $first, $operator, $second)
- crossJoin($table, $first = null, $operator = null, $second = null)
- mergeWheres($wheres, $bindings)
- tap($callback)
- where($column, $operator = null, $value = null, $boolean = 'and')
- orWhere($column, $operator = null, $value = null)
- whereColumn($first, $operator = null, $second = null, $boolean = 'and')
- orWhereColumn($first, $operator = null, $second = null)
- whereRaw($sql, $bindings = [], $boolean = 'and')
- orWhereRaw($sql, array $bindings = [])
- whereIn($column, $values, $boolean = 'and', $not = false)
- orWhereIn($column, $values)
- whereNotIn($column, $values, $boolean = 'and')
- orWhereNotIn($column, $values)
- whereNull($column, $boolean = 'and', $not = false)
- orWhereNull($column)
- whereNotNull($column, $boolean = 'and')
- whereBetween($column, array $values, $boolean = 'and', $not = false)
- orWhereBetween($column, array $values)
- whereNotBetween($column, array $values, $boolean = 'and')
- orWhereNotBetween($column, array $values)
- orWhereNotNull($column)
- whereDate($column, $operator, $value = null, $boolean = 'and')
- orWhereDate($column, $operator, $value)
- whereTime($column, $operator, $value, $boolean = 'and')
- orWhereTime($column, $operator, $value)
- whereDay($column, $operator, $value = null, $boolean = 'and')
- whereMonth($column, $operator, $value = null, $boolean = 'and')
- whereYear($column, $operator, $value = null, $boolean = 'and')
- whereNested(Closure $callback, $boolean = 'and')
- addNestedWhereQuery($query, $boolean = 'and')
- whereExists(Closure $callback, $boolean = 'and', $not = false)
- orWhereExists(Closure $callback, $not = false)
- whereNotExists(Closure $callback, $boolean = 'and')
- orWhereNotExists(Closure $callback)
- addWhereExistsQuery(Builder $query, $boolean = 'and', $not = false)
- dynamicWhere($method, $parameters)
- groupBy()
- having($column, $operator = null, $value = null, $boolean = 'and')
- orHaving($column, $operator = null, $value = null)
- havingRaw($sql, array $bindings = [], $boolean = 'and')
- orHavingRaw($sql, array $bindings = [])
- orderBy($column, $direction = 'asc')
- orderByDesc($column)
- latest($column = 'created_at')
- oldest($column = 'created_at')
- inRandomOrder($seed = '')
- orderByRaw($sql, $bindings = [])
- skip($value)
- offset($value)
- take($value)
- limit($value)
- forPage($page, $perPage = 15)
- forPageAfterId($perPage = 15, $lastId = 0, $column = 'id')
- union($query, $all = false)
- unionAll($query)
- lock($value = true)
- lockForUpdate()
- sharedLock()
- when($value, $callback, $default = null)
- unless($value, $callback, $default = null)
- whereKey($id)
- whereKeyNot($id)
- with($relations)
- without($relations)
- setQuery($query)
- setModel(Model $model)
- has($relation, $operator = '>=', $count = 1, $boolean = 'and', Closure $callback = null)
- orHas($relation, $operator = '>=', $count = 1)
- doesntHave($relation, $boolean = 'and', Closure $callback = null)
- whereHas($relation, Closure $callback = null, $operator = '>=', $count = 1)
- orWhereHas($relation, Closure $callback = null, $operator = '>=', $count = 1)
- whereDoesntHave($relation, Closure $callback = null)
- withCount($relations)
- mergeConstraintsFrom(Builder $from)
- withTrashed()
- withoutTrashed()
- onlyTrashed()

## Usage

### Eloquent

#### Create a Model

Create your model normally, but it is important to define the attributes that can be filled from the input form data.

```php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'author',
    ];
}
```

### Create a Contract

```php

namespace App\Repositories\Contracts;

interface PostRepository
{

}
```

#### Create a Repository

```php

namespace App\Repositories;

use App\Repositories\Contracts\PostRepository as PostRepositoryContract;
use App\Post;
use Recca0120\Repository\EloquentRepository;

class PostRepository extends EloquentRepository implements PostRepositoryContract
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }
}
```

### Bind

```php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\PostRepository as PostRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PostRepositoryContract::class, PostRepository::class);
    }
}

```

#### Controller

```php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepository;

class PostsController extends Controller
{
    protected $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }
}
```

## Methods

Find all results in Repository

```php
$posts = $this->repository->get();
```

Find all results in Repository with pagination

```php
$posts = $this->repository->paginate();
```

Count results in Repository

```php
$posts = $this->repository->count();
```

Create new entry in Repository

```php
$post = $this->repository->create(request()->all());
```

Update entry in Repository

```php
$post = $this->repository->update($id, request()->all());
```

Delete entry in Repository

```php
$this->repository->delete($id);
```

New instance

```php
$post = $this->repository->newInstance([
    'author' => 'author'
]);
```

Return Model With Conditions

```
$model = $this->repository->matching(Criteria::create()->where('title', '=', 'title'));
```

Find result by id

```php
$post = $this->repository->find($id);
```

### Find by conditions

#### Using the Criteria

Criteria is support all of Eloquent functions

##### Single Criteria

```php

use Recca0120\Repository\Criteria;

$criteria = Criteria::create()
    ->select('*')
    ->where('author', '=', 'author')
    ->orWhere('title', '=', 'title')
    ->orderBy('author', 'asc');

$this->repository->get($criteria);
$this->repository->paginate($criteria);
```

#### Multiple Criteria

```php

use Recca0120\Repository\Criteria;

$criteria = [];

$criteria[] = Criteria::create()
    ->orderBy('author', 'asc');

$criteria[] = Criteria::create()
    ->where('author', '=', 'author')
    ->orWhere('title', '=', 'title');

$this->repository->get($criteria);
// $this->repository->paginate($criteria);
```

##### With

```php

use Recca0120\Repository\Criteria;

$criteria = Criteria::create()
    ->with('author', function($criteria) {
        $criteria->where('author', 'author');
    });

$this->repository->get($criteria);
// $this->repository->paginate($criteria);
```

#### Join

```php

use Recca0120\Repository\Criteria;

$criteria = Criteria::create()
    ->join('author', function ($criteria) {
        $criteria->on('posts.author_id', '=', 'author.id');
    });

$this->repository->get($criteria);
// $this->repository->paginate($criteria);
```

#### Expression

```php

use Recca0120\Repository\Criteria;

$criteria = Criteria::create()
    ->where('created_at', '<=', Criteria::expr('NOW()'));

$this->repository->get($criteria);
// $this->repository->paginate($criteria);
```

#### Custom Criteria

```php

use Recca0120\Repository\Criteria;

class CustomCriteria extends Criteria
{
    public function __construct($id)
    {
        $this->where('id', '=', $id);
    }
}

$this->repository->get((new CustomCriteria(1))->where('autor', 'autor'));
```

## ToDo
- Cache
