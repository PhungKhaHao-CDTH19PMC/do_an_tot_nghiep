<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'fullname'  => 'Super Admin',
            'username'  => 'superadmin',
            'password'  => Hash::make('123456'),
            'email'     => '0306191292@caothang.edu.vn',
        ]);
    }
}
