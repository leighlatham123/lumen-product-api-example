<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
        ->insert(
            [
                'user_name' => env('DEFAULT_USER_NAME', 'secure_user'),
                'user_password' => Hash::make(env('DEFAULT_USER_PASS', 'secure_password')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        );
    }
}
