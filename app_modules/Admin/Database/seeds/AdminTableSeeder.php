<?php

use App\Config\AppConstants;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name' => 'Management',
                'email' => 'developteamshoplm@gmail.com',
                'phone' => '0968793103',
                'address' => 'Hà Nội',
                'birthday' => '2000-09-07',
                'gender' => 1,
                'avatar_path' => '1jty245QlzVz5wb4nGgR_xky7KpNRuACI',
                'password' => Hash::make(AppConstants::ADM_PASSWORD_DEFAULT),
                'timeout' => Carbon::now()->addYears(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin 1',
                'email' => 'adminmaster1@gmail.com',
                'phone' => '0000000001',
                'address' => 'Ninh Bình',
                'birthday' => '1999-10-02',
                'gender' => 1,
                'avatar_path' => '17UdcK95mjJLwqwDNuPst7aP3NxcdSurA',
                'password' => Hash::make(AppConstants::ADM_PASSWORD_DEFAULT),
                'timeout' => Carbon::now()->addYears(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin 2',
                'email' => 'adminmaster2@gmail.com',
                'phone' => '0000000002',
                'address' => 'Ninh Thuận',
                'birthday' => '1999-01-14',
                'gender' => 2,
                'avatar_path' => '1bhSaKOtpc3RfvJeEqTP8te9W5IsKNwIU',
                'password' => Hash::make(AppConstants::ADM_PASSWORD_DEFAULT),
                'timeout' => Carbon::now()->addYears(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin 3',
                'email' => 'adminmaster3@gmail.com',
                'phone' => '0000000003',
                'address' => 'Bình Dương',
                'birthday' => '1993-05-11',
                'gender' => 1,
                'avatar_path' => '1_EbwQOlOGtlW5nJmket1VBcUsS7_il0v',
                'password' => Hash::make(AppConstants::ADM_PASSWORD_DEFAULT),
                'timeout' => Carbon::now()->addYears(2),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
