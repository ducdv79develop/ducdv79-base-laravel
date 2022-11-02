<?php

namespace App\Repositories;

interface BaseRepository
{
    const TAKE = 15;
    const ORDER_BY = 'id desc';

    /**
     * @return mixed
     */
    public function query();

    /**
     * @param int $id
     * @param array $with
     * @param string[] $columns
     * @return mixed
     */
    public function findOrFail(int $id, $with = array(), $columns = array('*'));

    /**
     * @param int $id
     * @param array $with
     * @param string[] $columns
     * @return mixed
     */
    public function find(int $id, $with = array(), $columns = array('*'));

    /**
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed
     */
    public function all($orderBy = self::ORDER_BY, $columns = array('*'));

    /**
     * @param int $perPage
     * @param string[] $columns
     * @return mixed
     */
    public function paginate($perPage = self::TAKE, $columns = array('*'));

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id);

    /**
     * @param array $data
     * @param array $conditions
     * @return mixed
     */
    public function updateConditions(array $data, $conditions = array());

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param array $whereData
     * @return mixed
     */
    public function deleteConditions($whereData = array());

    /**
     * @param array $whereData
     * @return int
     */
    public function count($whereData = array()): int;

    /**
     * @param $attribute
     * @param $value
     * @param array $with
     * @param string $orderBy
     * @param string[] $columns
     * @return object|null
     */
    public function findBy($attribute, $value, $with = array(), $orderBy = self::ORDER_BY, $columns = array('*')): ?object;

    /**
     * @param array $whereData
     * @param array $with
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed
     */
    public function findByConditionsFirst($whereData = array(), $with = array(), $orderBy = self::ORDER_BY, $columns = array('*'));

    /**
     * @param array $whereData
     * @param array $with
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed
     */
    public function findByConditions($whereData = array(), $with = array(), $orderBy = self::ORDER_BY, $columns = array('*'));

    /**
     * @param $attribute
     * @param array $whereIn
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed
     */
    public function whereInData($attribute, $whereIn = array(), $orderBy = self::ORDER_BY, $columns = array('*'));

    /**
     * @param array $whereData
     * @param int $perPage
     * @param array $with
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed
     */
    public function pagingWithMultiConditions($whereData = array(), $perPage = self::TAKE, $with = array(), $orderBy = self::ORDER_BY, $columns = array('*'));

    /**
     * @param array $whereData
     * @param string $orderBy
     * @param array $with
     * @param string[] $select
     * @return mixed
     */
    public function getByMultiConditions($whereData = array(), $orderBy = self::ORDER_BY, $with = array(), $select = array("*"));

    /**
     * @param array $whereData
     * @param int $perPage
     * @param string[] $select
     * @param string $orderBy
     * @param array $with
     * @return mixed
     */
    public function getByMultiConditionsPaginate($whereData = array(), $perPage = self::TAKE, $select = array("*"), $orderBy = "id asc", $with = array());

    /**
     * @param array $whereData
     * @param array $conditionSearch
     * @param array $with
     * @param string $orderBy
     * @param string[] $select
     * @return mixed
     */
    public function searchMultipleWhere($whereData = array(), $conditionSearch = array(), $with = array(), $orderBy = self::ORDER_BY, $select = array("*"));

    /**
     * @param array $whereData
     * @param array $conditionSearch
     * @param int $perPage
     * @param array $with
     * @param string $orderBy
     * @param string[] $select
     * @return mixed
     */
    public function searchMultipleWherePagination($whereData = array(), $conditionSearch = array(), $perPage = self::TAKE, $with = array(), $orderBy = self::ORDER_BY, $select = array("*"));
}
