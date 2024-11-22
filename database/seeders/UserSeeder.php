<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'pepe',
            'last_name' => 'ejemplo',
            'email' => 'pepe@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('123456789'),
            'role' => 'super_admin',
            'remember_token' => null,
            'created_at' => '2024-09-04 07:13:34',
            'updated_at' => '2024-10-11 03:00:28',
        ]);
    }
}
