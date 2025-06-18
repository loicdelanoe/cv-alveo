<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        $superAdmin = User::factory()->create([
            'name' => 'Loïc Delanoë',
            'email' => 'loic@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('!azerty123'),
            'remember_token' => Str::random(10),
        ]);

        $superAdmin->assignRole('super-admin');

        $this->call(PageSeeder::class);

        $this->call(BlockTypeSeeder::class);

        $this->call(MenuSeeder::class);
    }
}
