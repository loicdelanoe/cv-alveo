<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::factory()
            ->hasAttached(Page::factory()
                ->count(3)
                ->state(['status' => 'published']
                ))
            ->create([
                'name' => 'Main Navigation',
                'slug' => 'main-navigation',
                'active' => true,
            ]);
    }
}
