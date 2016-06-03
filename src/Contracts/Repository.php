<?php

namespace Recca0120\Repository\Contracts;

interface Repository
{
    public function find($id);

    public function findAll();

    public function findBy($criteria, $limit = null, $offset = null);

    public function findOneBy($criteria);
}
