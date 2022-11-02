<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit = 5;
        for ($i = 1; $i <= $limit; $i++) {
            DB::table('customers')->insert([
                'name' => 'customer 0' . $i,
                'phone' => '096879310' . $i,
                'email' => 'customer0' . $i . '@gmail.com',
                'birthday' => '2000-09-07',
                'gender' => rand(1, 2),
                'verified_at' => Carbon::now()->addDays(10),
                'verified' => 1,
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
