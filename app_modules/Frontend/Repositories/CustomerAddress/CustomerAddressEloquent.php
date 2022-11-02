<?php

namespace App\Repositories\CustomerAddress;

use App\Models\CustomerAddress;
use App\Repositories\BaseEloquent;
use Illuminate\Support\Facades\DB;

class CustomerAddressEloquent extends BaseEloquent implements CustomerAddressRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel(): string
    {
        return CustomerAddress::class;
    }

    /**
     * @param $condition
     * @return mixed
     */
    public function getAddress($condition)
    {
        $query =  $this->query()
            ->select('name', 'phone', 'email', 'address_code', DB::raw('CONCAT(addr02, " ", addr01) AS address'));
        if (is_array($condition) && count($condition)) {
            $query->where($condition);
        }
        return $query->first();
    }
}
