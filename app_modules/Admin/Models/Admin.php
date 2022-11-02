<?php

namespace App\Models;

use App\Traits\ParentBoot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles, ParentBoot;

    /**
     * @var string
     */
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar_path', 'name', 'phone', 'email', 'address', 'birthday', 'gender', 'password', 'timeout', 'total_point'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $selects = [
        'id',
        'avatar_path',
        'name',
        'email',
        'phone',
        'address',
        'birthday',
        'timeout',
        'gender',
        'total_point',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * @param $value
     */
    public function setBirthdayAttribute($value)
    {
        if ($value) {
            $value = str_replace('/', '-', $value);
            $this->attributes['birthday'] = date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['birthday'] = null;
        }
    }

    /**
     * @return string[]
     */
    public function getSelects(): array
    {
        return $this->selects;
    }

    /**
     * @return BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, AdminProject::class)->withPivot(['*']);
    }
}
