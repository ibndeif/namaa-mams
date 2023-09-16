<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Enum\UserRole;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seed super admin
        User::create([
            'name' => 'Super Admin User',
            'email' => 'super@blog.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$DdPwwkL5MHF03WwkG2iWEuaAyRK4P8CM5Y.D71Nhzrf4hnRG.TQDC',
            'remember_token' => Str::random(10),
            'role' => UserRole::SuperAdmin->value,
        ]);

        //seed super admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@blog.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$DdPwwkL5MHF03WwkG2iWEuaAyRK4P8CM5Y.D71Nhzrf4hnRG.TQDC',
            'remember_token' => Str::random(10),
            'role' => UserRole::Admin->value,
        ]);

        //seed editor
        User::create([
            'name' => 'Editor User',
            'email' => 'editor@blog.test',
            'email_verified_at' => now(),
            'password' => '$2y$10$DdPwwkL5MHF03WwkG2iWEuaAyRK4P8CM5Y.D71Nhzrf4hnRG.TQDC',
            'remember_token' => Str::random(10),
            'role' => UserRole::Editor->value,
        ]);
    }
}
