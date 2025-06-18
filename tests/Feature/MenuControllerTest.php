<?php

use App\Models\Menu;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

    $user = User::factory()->create();
    $user->assignRole('super-admin');
    $this->actingAs($user);
});

it('renders the index page', function () {
    Menu::factory()->count(3)->create();

    $this->get(route('admin.menu.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Menu/Index'));
});

it('renders the create page', function () {
    Page::factory()->count(3)->create(['status' => 'published']);

    $this->get(route('admin.menu.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Menu/Create'));
});

it('stores a new menu with pages', function () {
    $pages = Page::factory()->count(2)->create(['status' => 'published']);

    $payload = [
        'name' => 'Main Menu',
        'slug' => 'main-menu',
        'active' => true,
        'pages' => $pages->pluck('id')->toArray(),
    ];

    $this->post(route('admin.menu.store'), $payload)
        ->assertRedirect();

    $this->assertDatabaseHas('menus', ['slug' => 'main-menu']);
    $this->assertDatabaseCount('navigations', 2);
});

it('shows a single menu', function () {
    $menu = Menu::factory()->create();
    $pages = Page::factory()->count(2)->create(['status' => 'published']);
    $menu->pages()->attach($pages);

    $this->get(route('admin.menu.show', $menu->slug))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Menu/Show'));
});

it('updates a menu and its pages', function () {
    $menu = Menu::factory()->create();
    $pages = Page::factory()->count(2)->create(['status' => 'published']);
    $menu->pages()->attach($pages);

    $updatedPages = Page::factory()->count(2)->create(['status' => 'published']);

    $payload = [
        'name' => 'Updated Menu',
        'slug' => 'updated-menu',
        'active' => false,
        'pages' => $updatedPages->pluck('id')->toArray(),
    ];

    $this->patch(route('admin.menu.update', $menu->slug), $payload)
        ->assertRedirect();

    $this->assertDatabaseHas('menus', ['slug' => 'updated-menu', 'active' => false]);
    $this->assertDatabaseCount('navigations', 2);
});

it('deletes a menu', function () {
    $menu = Menu::factory()->create();

    $this->delete(route('admin.menu.destroy', $menu->slug))
        ->assertRedirect();

    $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
});
