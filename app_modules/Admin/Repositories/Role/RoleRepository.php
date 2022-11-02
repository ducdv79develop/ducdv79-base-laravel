<?php

namespace App\Repositories\Role;

use App\Repositories\BaseRepository;

interface RoleRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function getPermissions();

    /**
     * @param int|object $roleOrId
     * @param array $permissions
     * @return false|object|mixed
     */
    public function syncPermissions($roleOrId, array $permissions);

    /**
     * @param int|object $roleOrId
     * @param array $permissions
     * @return false|object|mixed
     */
    public function givePermissionTo($roleOrId, array $permissions);

    /**
     * @return mixed
     */
    public function allRoleAdmins();
}
