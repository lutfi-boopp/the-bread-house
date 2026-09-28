<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'admin',
            ]
        );

        // Kasir
        User::updateOrCreate(
            ['email' => 'kasir@kasir.com'],
            [
                'name' => 'Petugas Kasir',
                'password' => Hash::make('password'), // password is 'password'
                'role' => 'kasir',
            ]
        );
    }
}
