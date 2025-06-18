<?php

use App\Models\Collection;
use App\Models\CollectionType;
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

it('renders the collection type index page', function () {
    CollectionType::factory()->count(3)->create();

    $this->get(route('admin.collection-type.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/CollectionType/Index'));
});

it('renders the collection type create page', function () {
    $this->get(route('admin.collection-type.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/CollectionType/Create'));
});

it('stores a new collection type', function () {
    $payload = [
        'name' => 'News',
        'type' => 'news',
        'fields' => [
            [
                'label' => 'Content',
                'name' => 'content',
                'type' => 'text',
                'validation' => ['required'],
            ],
        ],
    ];

    $this->post(route('admin.collection-type.store'), $payload)
        ->assertRedirect(route('admin.collection-type.show', 'news'));

    $this->assertDatabaseHas('collection_types', [
        'type' => 'news',
        'name' => 'News',
    ]);
});

it('shows a single collection type with its collections', function () {
    $collectionType = CollectionType::factory()->create();
    Collection::factory()->count(2)->create(['collection_type_id' => $collectionType->id]);

    $this->get(route('admin.collection-type.show', $collectionType->type))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/CollectionType/Show'));
});

it('deletes a collection type and its collections', function () {
    $collectionType = CollectionType::factory()->create();
    $collections = Collection::factory()->count(2)->create(['collection_type_id' => $collectionType->id]);

    $this->delete(route('admin.collection-type.destroy', $collectionType->type))
        ->assertRedirect(route('admin.page.index'));

    $this->assertDatabaseMissing('collection_types', ['id' => $collectionType->id]);

    foreach ($collections as $collection) {
        $this->assertDatabaseMissing('collections', ['id' => $collection->id]);
    }
});
