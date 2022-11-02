<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Models\Role;
use App\Repositories\BaseEloquent;
use Illuminate\Database\Eloquent\Collection;

class PermissionEloquent extends BaseEloquent implements PermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function getModel(): string
    {
        return Permission::class;
    }

    /**
     * @return Permission[]|Collection
     */
    public function getPermissions()
    {
        return Permission::all()->groupBy('group');
    }

    /**
     * @param int|object $roleOrId
     * @param array $permissions
     * @return false|object|mixed
     */
    public function syncPermissions($roleOrId, array $permissions)
    {
        if (is_object($roleOrId)) {
            $role = $roleOrId;
        } else {
            $role = $this->find($roleOrId);
        }
        if (empty($role)) {
            return false;
        }
        $role->syncPermissions($permissions);
        return $role;
    }

    /**
     * @param int|object $roleOrId
     * @param array $permissions
     * @return false|object|mixed
     */
    public function givePermissionTo($roleOrId, array $permissions)
    {
        if (is_object($roleOrId)) {
            $role = $roleOrId;
        } else {
            $role = $this->find($roleOrId);
        }
        if (empty($role)) {
            return false;
        }
        $role->givePermissionTo($permissions);
        return $role;
    }
}
