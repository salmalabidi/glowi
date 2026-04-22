<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'salma@gmail.com'],
            [
                'name' => 'Salma Admin',
                'password' => Hash::make('salma'),
                'is_admin' => true,
            ]
        );
    }
}