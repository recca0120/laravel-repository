<?php

namespace Recca0120\Repository\Contracts;

interface EloquentRepository extends Repository
{
    /**
     * create.
     * @method create
     * @param  array $data
     * @return mixed
     */
    public function create($data);

    /**
     * update.
     * @method update
     * @param  array $data 
     * @param  int $id   
     * @return mixed       
     */
    public function update($data, $id);

    /**
     * delete.
     * @method delete
     * @param  int $id 
     * @return bool     
     */
    public function delete($id);
}
