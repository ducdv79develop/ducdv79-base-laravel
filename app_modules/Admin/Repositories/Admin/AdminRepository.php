<?php

namespace App\Repositories\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

interface AdminRepository extends BaseRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function getDataById($id);

    /**
     * @return mixed
     */
    public function commonQuery();
}
