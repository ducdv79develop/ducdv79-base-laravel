<?php

namespace App\Repositories\CustomerAddress;

use App\Repositories\BaseRepository;

interface CustomerAddressRepository extends BaseRepository
{
    /**
     * @param $condition
     * @return mixed
     */
    public function getAddress($condition);
}
