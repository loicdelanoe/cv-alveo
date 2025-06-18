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

it('renders the index page', function () {
    Collection::factory()->count(3)->create();
    CollectionType::factory()->count(2)->create();

    $this->get(route('admin.collection.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Collection/Index'));
});

it('renders the create page', function () {
    $collectionType = CollectionType::factory()->create();

    $this->get(route('admin.collection.create', $collectionType->type))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Collection/Create'));
});

it('stores a new collection', function () {
    $collectionType = CollectionType::factory()->create([
        'fields' => [ // Exemple minimal, adapte selon tes besoins
            ['name' => 'content', 'type' => 'text', 'validation' => ['required']],
        ],
    ]);

    $payload = [
        'status' => 'published',
        'title' => 'My Collection Title',
        'slug' => 'my-collection-title',
        'meta_description' => 'A description',
        'meta_title' => 'Meta Title',
        'og_type' => 'website',
        'content' => ['content' => 'Sample content'],
        // suppose validateBlock adds no extra fields or you can mock it accordingly
    ];

    $this->post(route('admin.collection.store', $collectionType->type), $payload)
        ->assertRedirect(route('admin.collection.show', [
            'collectionType' => $collectionType->type,
            'collection' => 'my-collection-title',
        ]));

    $this->assertDatabaseHas('collections', [
        'slug' => 'my-collection-title',
        'collection_type_id' => $collectionType->id,
    ]);
});

it('shows a single collection', function () {
    $collectionType = CollectionType::factory()->create();
    $collection = Collection::factory()->create([
        'collection_type_id' => $collectionType->id,
    ]);

    $this->get(route('admin.collection.show', [$collectionType->type, $collection->slug]))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Collection/Show'));
});

it('updates a collection', function () {
    $collectionType = CollectionType::factory()->create();
    $collection = Collection::factory()->create([
        'collection_type_id' => $collectionType->id,
        'title' => 'Old Title',
        'slug' => 'old-slug',
    ]);

    $payload = [
        'title' => 'Updated Title',
        'slug' => 'updated-slug',
        'status' => 'draft',
        'meta_description' => 'Updated description',
        'meta_title' => 'Updated meta title',
        'og_type' => 'article',
    ];

    $this->patch(route('admin.collection.update', [$collectionType->type, $collection->slug]), $payload)
        ->assertRedirect();

    $this->assertDatabaseHas('collections', [
        'id' => $collection->id,
        'title' => 'Updated Title',
        'slug' => 'updated-slug',
        'status' => 'draft',
    ]);
});

it('deletes a collection', function () {
    $collection = Collection::factory()->create();
    $collectionType = CollectionType::factory()->create();
    $collection->collectionType()->associate($collectionType)->save();

    $this->delete(route('admin.collection.destroy', $collection->slug))
        ->assertRedirect(route('admin.collection-type.show', $collectionType));

    $this->assertDatabaseMissing('collections', [
        'id' => $collection->id,
    ]);
});
