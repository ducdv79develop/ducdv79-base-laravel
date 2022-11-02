<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\BaseEloquent;

class CustomerEloquent extends BaseEloquent implements CustomerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel(): string
    {
        return Customer::class;
    }
}
