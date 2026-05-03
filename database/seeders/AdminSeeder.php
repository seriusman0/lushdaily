<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@lushdaily.com'],
            [
                'name'     => 'Admin Lush Daily',
                'password' => 'admin321',
                'role'     => 'admin',
            ]
        );
    }
}
