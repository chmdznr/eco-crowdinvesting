<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'              => 1,
                'name'            => 'Admin',
                'email'           => 'admin@admin.com',
                'password'        => bcrypt('password'),
                'remember_token'  => null,
                'approved'        => 1,
                'two_factor_code' => '',
                'nik'             => '',
                'tempat_lahir'    => '',
                'no_hp'           => '',
            ],
        ];

        User::insert($users);
    }
}
