<?php

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

    $user = User::factory()->create();
    $user->assignRole('super-admin');
    $this->actingAs($user);
});

it('renders the user index page', function () {
    User::factory()->count(3)->create();

    $this->get(route('admin.user.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/User/Index'));
});

it('renders the user create page', function () {
    $this->get(route('admin.user.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/User/Create'));
});

it('stores a new user', function () {
    $payload = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $this->post(route('admin.user.store'), $payload)
        ->assertRedirect();

    $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
});

it('shows a single user with permissions', function () {
    $user = User::factory()->create();
    $permission = Permission::create(['name' => 'edit articles']);
    $user->givePermissionTo($permission);

    $this->get(route('admin.user.show', $user->id))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/User/Show'));
});

it('updates a user and syncs permissions', function () {
    $user = User::factory()->create();

    $payload = [
        'name' => 'Updated Name',
        'permissions' => ['edit users'],
    ];

    $this->patch(route('admin.user.update', $user), $payload)
        ->assertRedirect();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
    ]);

    $user->refresh();
    expect($user->hasPermissionTo('edit users'))->toBeTrue();
});

it('deletes a user', function () {
    $user = User::factory()->create();

    $this->delete(route('admin.user.destroy', $user->id))
        ->assertRedirect();

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
