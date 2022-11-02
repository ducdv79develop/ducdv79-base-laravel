<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => ROLE_SYSTEM_MANAGEMENT,
                'guard_name' => 'admin',
                'display_name' => 'Quản trị hệ thống',
            ],
            [
                'name' => ROLE_ADMIN,
                'guard_name' => 'admin',
                'display_name' => 'Quản trị viên',
            ],
            [
                'name' => ROLE_FINANCE,
                'guard_name' => 'admin',
                'display_name' => 'Chuyên gia tài chính',
            ],
            [
                'name' => ROLE_CENSOR,
                'guard_name' => 'admin',
                'display_name' => 'Người kiểm duyệt',
            ],
            [
                'name' => ROLE_SALESMAN,
                'guard_name' => 'admin',
                'display_name' => 'Người bán hàng',
            ]
        ];
        DB::table('roles')->insert($roles);

        $perGroup = [
            PER_GROUP_ROLE => 'Quyền hạn',
            PER_GROUP_ADMIN => 'Hội viên',
            PER_GROUP_ANALYSE => 'Thống kê',
            PER_GROUP_PROJECT => 'Dự án',
            PER_GROUP_BORROWER => 'Khách vay',
            PER_GROUP_TRANSACTION => 'Giao dịch vay',
            PER_GROUP_PRODUCT => 'Sản phẩm',
            PER_GROUP_CATEGORY => 'Danh mục',
            PER_GROUP_ORDER => 'Đơn hàng',
        ];
        $permissions = [];
        $roles = [];
        $permission_id = 1;
        foreach ($perGroup as $key => $group) {
            $permissions[] = [
                'id' => $permission_id,
                'name' => $key . "_" . PER_ACTION_READ,
                'guard_name' => 'admin',
                'display_name' => 'Xem ' . $group,
                'group_name' => $key,
                'display_group_name' => $group,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $roles[] = [
                'permission_id' => $permission_id,
                'role_id' => 1,
            ];
            $permission_id++;

            $permissions[] = [
                'id' => $permission_id,
                'name' => $key . "_" . PER_ACTION_WRITE,
                'guard_name' => 'admin',
                'display_name' => 'Sửa ' . $group,
                'group_name' => $key,
                'display_group_name' => $group,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $roles[] = [
                'permission_id' => $permission_id,
                'role_id' => 1,
            ];
            $permission_id++;
        }
        DB::table('permissions')->insert($permissions);
        DB::table('role_has_permissions')->insert($roles);
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\Admin',
            'model_id' => SYSTEM_MANAGEMENT_ADMIN_ID,
        ]);
    }
}
