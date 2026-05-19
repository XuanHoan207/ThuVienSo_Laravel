<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Tài khoản Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@thuvienso.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        // User test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
