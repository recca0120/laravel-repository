<?php

namespace Recca0120\Repository\Contracts;

interface Repository
{
    /**
     * find.
     *
     * @method find
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * findAll.
     *
     * @method findAll
     *
     * @return \Illuminate\Support\Collection
     */
    public function findAll();

    /**
     * findBy.
     *
     * @method findBy
     *
     * @param mixed $criteria
     * @param int   $limit
     * @param int   $offset
     *
     * @return @return \Illuminate\Support\Collection
     */
    public function findBy($criteria, $limit = null, $offset = null);

    /**
     * findOneBy.
     *
     * @method findOneBy
     *
     * @param mixed $criteria
     *
     * @return mixed
     */
    public function findOneBy($criteria);

    /**
     * findOneBy.
     *
     * @method findOneBy
     *
     * @param mixed $criteria
     *
     * @return mixed
     */
    public function matching($criteria);

    /**
     * paginatedAll.
     *
     * @method paginatedAll
     *
     * @param int $perPage
     *
     * @return |illuminate\Pagination\AbstractPaginator
     */
    public function paginatedAll($perPage = null, $pageName = 'page', $page = null);

    /**
     * paginatedBy.
     *
     * @method paginatedBy
     *
     * @param mixed $criteria
     * @param int   $perPage
     *
     * @return |illuminate\Pagination\AbstractPaginator
     */
    public function paginatedBy($criteria, $perPage = null, $pageName = 'page', $page = null);

    /**
     * create.
     *
     * @method create
     *
     * @param array $data
     * @param bool  $forceFill
     *
     * @return mixed
     */
    public function create($data, $forceFill = false);

    /**
     * update.
     *
     * @method update
     *
     * @param array $data
     * @param int   $id
     * @param bool  $forceFill
     *
     * @return mixed
     */
    public function update($data, $id, $forceFill = false);

    /**
     * delete.
     *
     * @method delete
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete($id);

    /**
     * cloneModel.
     *
     * @method cloneModel
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function cloneModel();

    /**
     * newInstance.
     *
     * @method newInstance
     *
     * @return \Illuminate\Database\Eloquent
     */
    public function newInstance($data);
}
