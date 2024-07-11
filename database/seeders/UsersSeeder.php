<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'admin',
            'password' => Hash::make('password'),
            'role' => '0',
        ]);

        User::create([
            'name' => 'user',
            'password' => Hash::make('password'),
            'role' => '1',
        ]);
    }
}
