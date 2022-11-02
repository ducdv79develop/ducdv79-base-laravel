<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\BaseEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdminEloquent extends BaseEloquent implements AdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel(): string
    {
        return Admin::class;
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getDataById($id)
    {
        $condition = $this->commonQuery();
        return $condition->where('admins.id', $id)->first();
    }

    /**
     * @return mixed
     */
    public function commonQuery()
    {
        $selects = [
            'admins.id',
            'admins.avatar_path',
            'admins.name',
            'admins.email',
            'admins.phone',
            'admins.address',
            'admins.birthday',
            'admins.timeout',
            'admins.gender',
            'admins.status',
            'admins.created_by',
            'admins.updated_by',
            'admins.created_at',
            'admins.updated_at',
            't1.name AS created_by_name',
            't2.name AS updated_by_name',
        ];
        return $this->query()
            ->leftJoin('admins AS t1', 't1.id', '=', 'admins.created_by')
            ->leftJoin('admins AS t2', 't2.id', '=', 'admins.updated_by')
            ->select($selects);
    }
}
