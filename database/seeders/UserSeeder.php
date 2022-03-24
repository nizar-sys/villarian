<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
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
        $users = [
            [
                'uuid' => Str::uuid(),
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'uuid' => Str::uuid(),
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => Hash::make('password'),
                'role' => 'user'
            ],
        ];

        User::insert($users);
    }
}
