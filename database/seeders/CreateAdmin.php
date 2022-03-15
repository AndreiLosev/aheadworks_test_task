<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert([
                'login' => 'admin',
                'password' => Hash::make('admin'),
                'token' => Hash::make('1_admin'),
                'role_id' => 1,
                'created_at' => now()
            ]);
    }
}
