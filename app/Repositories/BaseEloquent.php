<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class BaseEloquent implements BaseRepository
{
    /**
     * @var $model
     */
    protected $model;

    /**
     * EloquentRepository constructor.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * @throws BindingResolutionException
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * @param int $id
     * @param array $with
     * @param string[] $columns
     * @return mixed
     */
    public function findOrFail(int $id, $with = array(), $columns = array('*'))
    {
        return $this->model->with($with)->findOrFail($id, $columns);
    }

    /**
     * @param int $id
     * @param array $with
     * @param string[] $columns
     * @return mixed
     */
    public function find(int $id, $with = array(), $columns = array('*'))
    {
        return $this->model->with($with)->find($id, $columns);
    }

    /**
     * @param string $orderBy
     * @param array $columns
     * @return mixed array
     */
    public function all($orderBy = self::ORDER_BY, $columns = array('*'))
    {
        return $this->model->orderByRaw($orderBy)->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = self::TAKE, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data Array data
     * @return void
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data Array data
     * @param $id
     * @return void
     */
    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    /**
     * @param array $data Array data
     * @param array $conditions
     * @return void
     */
    public function updateConditions(array $data, $conditions = array())
    {
        return $this->model->where($conditions)->update($data);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param array $whereData
     * @return mixed
     */
    public function deleteConditions($whereData = array())
    {
        return $this->model->where($whereData)->delete();
    }

    /**
     * @param array $whereData
     * @return int
     */
    public function count($whereData = array()): int
    {
        if ($whereData) {
            return $this->model->where($whereData)->count();
        }
        return $this->model->count();
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $with
     * @param string $orderBy
     * @param array $columns Columns
     * @return object|null
     */
    public function findBy($attribute, $value, $with = array(), $orderBy = self::ORDER_BY, $columns = array('*')): ?object
    {
        return $this->model
            ->orderByRaw($orderBy)
            ->where($attribute, '=', $value)
            ->with($with)
            ->first($columns);
    }

    /**
     * @param array $whereData
     * @param array $with
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed
     */
    public function findByConditionsFirst($whereData = array(), $with = array(), $orderBy = self::ORDER_BY, $columns = array('*'))
    {
        return $this->model
            ->orderByRaw($orderBy)
            ->where($whereData)
            ->with($with)
            ->first($columns);
    }

    /**
     * @param array $whereData Array where data
     * @param array $with
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed array
     */
    public function findByConditions($whereData = array(), $with = array(), $orderBy = self::ORDER_BY, $columns = array('*'))
    {
        return $this->model
            ->orderByRaw($orderBy)
            ->where($whereData)
            ->select($columns)
            ->with($with)
            ->get();
    }

    /**
     * @param $attribute
     * @param array $whereIn
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed
     */
    public function whereInData($attribute, $whereIn = array(), $orderBy = self::ORDER_BY, $columns = array('*'))
    {
        return $this->model
            ->whereIn($attribute, $whereIn)
            ->orderByRaw($orderBy)
            ->select($columns)
            ->get();
    }

    /**
     * @param array $whereData Array where data
     * @param int $perPage
     * @param array $with
     * @param string $orderBy
     * @param string[] $columns
     * @return mixed array
     */
    public function pagingWithMultiConditions($whereData = array(), $perPage = self::TAKE, $with = array(), $orderBy = self::ORDER_BY, $columns = array('*'))
    {
        return $this->model
            ->orderByRaw($orderBy)
            ->where($whereData)
            ->with($with)
            ->paginate($perPage, $columns);
    }

    /**
     * @param array $whereData
     * @param string $orderBy
     * @param array $select
     * @param array $with
     * @return mixed
     */
    public function getByMultiConditions($whereData = array(), $orderBy = self::ORDER_BY, $with = array(), $select = array("*"))
    {
        return $this->model
            ->select($select)
            ->where($whereData)
            ->orderByRaw($orderBy)
            ->with($with)
            ->get();
    }

    /**
     * @param array $whereData
     * @param int $perPage
     * @param string[] $select
     * @param string $orderBy
     * @param array $with
     * @return mixed
     */
    public function getByMultiConditionsPaginate($whereData = array(), $perPage = self::TAKE, $select = array("*"), $orderBy = "id asc", $with = array())
    {
        return $this->model
            ->select($select)
            ->where($whereData)
            ->orderByRaw($orderBy)
            ->with($with)
            ->paginate($perPage);
    }

    /**
     * @param array $whereData
     * @param array $conditionSearch
     * @param string[] $select
     * @param string $orderBy
     * @param array $with
     * @return mixed
     */
    public function searchMultipleWhere($whereData = array(), $conditionSearch = array(), $with = array(), $orderBy = self::ORDER_BY, $select = array("*"))
    {
        $model = $this->multipleConditionSearch($whereData, $conditionSearch);
        return $model
            ->select($select)
            ->orderByRaw($orderBy)
            ->with($with)
            ->get();
    }

    /**
     * @param array $whereData
     * @param array $conditionSearch
     * @param string[] $select
     * @param string $orderBy
     * @param int $perPage
     * @param array $with
     * @return mixed
     */
    public function searchMultipleWherePagination($whereData = array(), $conditionSearch = array(), $perPage = self::TAKE, $with = array(), $orderBy = self::ORDER_BY, $select = array("*"))
    {
        $model = $this->multipleConditionSearch($whereData, $conditionSearch);
        return $model
            ->select($select)
            ->orderByRaw($orderBy)
            ->with($with)
            ->paginate($perPage);
    }

    /**
     * @param array $whereData
     * @param array $conditionSearch
     * @return mixed
     */
    private function multipleConditionSearch($whereData = array(), $conditionSearch = array())
    {
        $model = $this->model
            ->where($whereData);
        if (!empty($conditionSearch)) {
            $model = $model->where(function ($query) use ($conditionSearch) {
                foreach ($conditionSearch as $key => $condition) {
                    if ($key == 0) {
                        $query = $query->where([$condition]);
                    } else {
                        $query = $query->orWhere([$condition]);
                    }
                }
                return $query;
            });
        }

        return $model;
    }
}
