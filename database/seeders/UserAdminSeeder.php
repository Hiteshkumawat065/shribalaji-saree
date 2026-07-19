<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            'name'              => 'Admin',
            'email'             => 'admin@saree.com',
            'password'          => Hash::make('saree@1234'),
            'role'              => 'superAdmin',
            'is_email_verify'   => true,
            'is_active'         => 1,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        DB::table('users')->insert([
            'name'              => 'Hitesh kumawat',
            'email'             => 'hitesh@yopmail.com',
            'password'          => Hash::make('saree@1234'),
            'role'              => 'superAdmin',
            'is_email_verify'   => true,
            'is_active'         => 1,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
