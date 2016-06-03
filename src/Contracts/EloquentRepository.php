<?php

namespace Recca0120\Repository\Contracts;

interface EloquentRepository extends Repository
{
    public function create($data);

    public function update($data, $id);

    public function delete($id);
}
