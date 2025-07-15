<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user (updateOrCreate to avoid duplicates)
        User::updateOrCreate(
            ['email' => 'admin@simprogma.test'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        // Create regular user (updateOrCreate to avoid duplicates)
        User::updateOrCreate(
            ['email' => 'user@simprogma.test'],
            [
                'name' => 'User Organisasi',
                'password' => bcrypt('user123'),
                'role' => 'user',
            ]
        );

        $this->call([
            StatusesTableSeeder::class,
        ]);
    }
}
