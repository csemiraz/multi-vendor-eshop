<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            //Admin 
            [
                'name' => 'Mr. Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'status' => 'active'
            ],

            //Venodr 
            [
                'name' => 'Mr. Vendor',
                'username' => 'vendor',
                'email' => 'vendor@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'vendor',
                'status' => 'active'
            ],

            //User // Customer
            [
                'name' => 'Mr. User',
                'username' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'status' => 'active'
            ]
        ]);
    }
}
