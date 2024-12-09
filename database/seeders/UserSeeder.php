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
        $now = now();
        DB::table('users')->insert([
            ['name' => 'Ariel',
            'last_name' => 'Director',
            'email' => 'ariel11@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('123456789'),
            'role' => 'super_admin',
            'remember_token' => null,
            'created_at' => $now, 
            'updated_at' => $now],
            ['name' => 'Mayra',
            'last_name' => 'Ore',
            'email' => 'may11@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => $now, 
            'updated_at' => $now],
            ['name' => 'Alejandra',
            'last_name' => 'Coria',
            'email' => 'ale11@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('12345678'),
            'role' => 'cliente',
            'remember_token' => null,
            'created_at' => $now, 
            'updated_at' => $now],
            ['name' => 'Florencia',
            'last_name' => 'Ruiz',
            'email' => 'flor11@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('12345678'),
            'role' => 'cliente',
            'remember_token' => null,
            'created_at' => $now, 
            'updated_at' => $now],
            ['name' => 'Omar',
            'last_name' => 'Orellana',
            'email' => 'omar11@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt('12345678'),
            'role' => 'cliente',
            'remember_token' => null,
            'created_at' => $now, 
            'updated_at' => $now],
        ]);
    }
}
