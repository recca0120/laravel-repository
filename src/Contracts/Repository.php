<?php

namespace Recca0120\Repository\Contracts;

interface Repository
{
    /**
     * find.
     * @method find
     * @param  int $id
     * @return mixed
     */
    public function find($id);

    /**
     * findAll.
     * @method findAll
     * @return \Illuminate\Support\Collection
     */
    public function findAll();

    /**
     * findBy.
     * @method findBy
     * @param  mixed $criteria
     * @param  int $limit
     * @param  int $offset
     * @return @return \Illuminate\Support\Collection
     */
    public function findBy($criteria, $limit = null, $offset = null);

    /**
     * findOneBy.
     * @method findOneBy
     * @param  mixed    $criteria
     * @return mixed
     */
    public function findOneBy($criteria);
}
