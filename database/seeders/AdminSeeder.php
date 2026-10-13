<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'Administrator',
            'email' => 'Admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'token' => '1'
        ]);
    }
}
