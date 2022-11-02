<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use App\Helpers\SortableLink;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Schema;

/**
 * Sortable trait.
 */
trait Sortable
{
    /**
     * @var array $cryptColumn
     */
    protected $cryptColumn = [
        'name',
        'name01',
        'name02',
        'kana01',
        'kana02',
        'email'
    ];

    /**
     * @param Builder $query
     * @param null $defaultParameters
     * @return Builder
     * @throws Exception
     */
    public function scopeSortAble(Builder $query, $defaultParameters = null): Builder
    {
        if (request()->has(['sort', 'direction'])) {
            return $this->queryOrderBuilder($query, request()->only(['sort', 'direction']));
        }

        if (is_null($defaultParameters)) {
            $defaultParameters = $this->getDefaultSortable();
        }

        if (!is_null($defaultParameters)) {
            $defaultSortArray = $this->formatToParameters($defaultParameters);
            if ( !empty($defaultSortArray)) {
                request()->merge($defaultSortArray);
            }
            return $this->queryOrderBuilder($query, $defaultSortArray);
        }
        return $query;
    }

    /**
     * @return array
     */
    public function getDefaultSortable(): ?array
    {

        $sortBy = Arr::first($this->sortable);
        if ( ! is_null($sortBy)) {
            return [$sortBy => 'asc'];
        }
        return null;
    }

    /**
     * @param $query
     * @param array $sortParameters
     * @return mixed
     * @throws Exception
     */
    private function queryOrderBuilder($query, array $sortParameters)
    {
        $model = $this;

        list($column, $direction) = $this->parseParameters($sortParameters);

        if (is_null($column)) {
            return $query;
        }

        $explodeResult = SortableLink::explodeSortParameter($column);
        if ( ! empty($explodeResult)) {
            $relationName = $explodeResult[0];
            $column       = $explodeResult[1];

            try {
                $relation = $query->getRelation($relationName);
                $query    = $this->queryJoinBuilder($query, $relation);
            } catch (Exception $e) {
                return $e->getMessage();
            }

            $model = $relation->getRelated();
        }

        if( in_array($column,$this->cryptColumn)) {
            $column = $model->getTable().'.'.$column;
            $query = $this->orderByRawColumn($query, $column, $direction);
        } else {
            $column = $model->getTable().'.'.$column;
            $query = $this->orderByOriginalColumn($query, $column, $direction);
        }
        return $query;
    }

    /**
     * @param array $parameters
     * @return array
     */
    private function parseParameters(array $parameters): array
    {
        $column = Arr::get($parameters, 'sort');
        if (empty($column)) {
            return [null, null];
        }

        $direction = Arr::get($parameters, 'direction', []);
        if ( ! in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'asc';
        }
        return [$column, $direction];
    }

    /**
     * @param array|string $array
     *
     * @return array
     */
    private function formatToParameters($array): array
    {
        if (empty($array)) {
            return [];
        }

        $defaultDirection = 'asc';

        if (is_string($array)) {
            return ['sort' => $array, 'direction' => $defaultDirection];
        }

        return (key($array) === 0) ? ['sort' => $array[0], 'direction' => $defaultDirection] : [
            'sort'      => key($array),
            'direction' => reset($array),
        ];
    }

    /**
     * @param Builder $query
     * @param BelongsTo|HasOne $relation
     * @return Builder
     * @throws Exception
     */
    private function queryJoinBuilder(Builder $query, $relation): Builder
    {
        $relatedTable = $relation->getRelated()->getTable();
        $parentTable  = $relation->getParent()->getTable();

        if ($parentTable === $relatedTable) {
            $query       = $query->from($parentTable.' as parent_'.$parentTable);
            $parentTable = 'parent_'.$parentTable;
            $relation->getParent()->setTable($parentTable);
        }
        if ($relation instanceof HasOne) {
            $relatedPrimaryKey = $relation->getQualifiedForeignKeyName();
            $parentPrimaryKey  = $relation->getQualifiedParentKeyName();
        } elseif ($relation instanceof BelongsTo) {
            $relatedPrimaryKey = $relation->getQualifiedOwnerKeyName();
            $parentPrimaryKey  = $relation->getQualifiedForeignKeyName();
        } else {
            throw new Exception();
        }

        return $this->formJoin($query, $parentTable, $relatedTable, $parentPrimaryKey, $relatedPrimaryKey);
    }

    /**
     * @param $model
     * @param $column
     *
     * @return bool
     */
    private function columnExists($model, $column): bool
    {
        return (isset($model->sortable)) ? in_array($column, $model->sortable) :
            Schema::connection($model->getConnectionName())->hasColumn($model->getTable(), $column);
    }

    /**
     * @param $query
     * @param $column
     * @param $direction
     * @return mixed
     */
    private function orderByOriginalColumn($query, $column, $direction)
    {
        return $query->orderBy($column, $direction);
    }

    /**
     * @param $query
     * @param $column
     * @param $direction
     * @return mixed
     */
    private function orderByRawColumn($query, $column, $direction)
    {
        $orderby = 'FROM_BASE64('.$column.') '.$direction.'';
        return $query->orderByRaw($orderby);
    }

    /**
     * @param $query
     * @param $parentTable
     * @param $relatedTable
     * @param $parentPrimaryKey
     * @param $relatedPrimaryKey
     *
     * @return mixed
     */
    private function formJoin($query, $parentTable, $relatedTable, $parentPrimaryKey, $relatedPrimaryKey)
    {
        $joinType = 'leftJoin';
        return $query->select($parentTable.'.*')->{$joinType}($relatedTable, $parentPrimaryKey, '=', $relatedPrimaryKey);
    }
}

