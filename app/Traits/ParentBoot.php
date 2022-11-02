<?php

namespace App\Traits;

use Carbon\Carbon;

trait ParentBoot
{
    /**
     * DeleteFlagScope
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($data) {
            $data->created_at = Carbon::now();
            $data->created_by = adminInfo('id');
            $data->updated_at = Carbon::now();
            $data->updated_by = adminInfo('id');
        });

        self::saving(function ($data) {
            $data->updated_at = Carbon::now();
            $data->updated_by = adminInfo('id');
        });

        self::created(function ($data) {

        });

        self::updated(function ($data) {

        });
    }
}
