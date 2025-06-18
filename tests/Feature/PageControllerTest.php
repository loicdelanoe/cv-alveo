<?php

use App\Models\Block;
use App\Models\BlockType;
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
    Page::factory()->count(3)->create();

    $this->get(route('admin.page.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Page/Index'));
});

it('renders the create page', function () {
    Block::factory()->count(2)->create();
    BlockType::factory()->count(2)->create();

    $this->get(route('admin.page.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Page/Create'));
});

it('stores a new page with blocks', function () {
    $blocks = Block::factory()->count(2)->create();

    $payload = [
        'status' => 'draft',
        'title' => 'New Page',
        'slug' => 'new-page',
        'meta_title' => 'Meta Title',
        'meta_description' => 'Meta Description',
        'og_type' => 'website',
        'blocks' => $blocks->toArray(),
    ];

    $this->post(route('admin.page.store'), $payload)
        ->assertRedirect();

    $this->assertDatabaseHas('pages', ['slug' => 'new-page']);
    $this->assertDatabaseHas('sections', ['block_id' => $blocks[0]->id]);
});

it('shows a single page', function () {
    $page = Page::factory()->create();
    Block::factory()->count(2)->create();
    BlockType::factory()->count(2)->create();

    $this->get(route('admin.page.show', $page->slug))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Page/Show'));
});

it('updates a page and its blocks', function () {
    $page = Page::factory()->create();
    $blocks = Block::factory()->count(2)->create();
    $page->blocks()->attach($blocks->pluck('id'));

    $payload = [
        'status' => 'published',
        'title' => 'Updated Title',
        'slug' => 'updated-title',
        'meta_title' => 'Updated Meta',
        'meta_description' => 'Updated Description',
        'og_type' => 'article',
        'blocks' => $blocks->map(fn ($block) => [
            'id' => $block->id,
            'content' => 'Modified content',
        ])->toArray(),
    ];

    $this->patch(route('admin.page.update', $page), $payload)
        ->assertRedirect();

    $this->assertDatabaseHas('pages', ['slug' => 'updated-title']);
    $this->assertDatabaseHas('blocks', ['content' => 'Modified content']);
});

it('deletes a page', function () {
    $page = Page::factory()->create();

    $this->delete(route('admin.page.destroy', $page->slug))
        ->assertRedirect();

    $this->assertDatabaseMissing('pages', ['id' => $page->id]);
});

it('renders the settings page', function () {
    Page::factory()->count(2)->create();

    $this->get(route('admin.page.settings'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Page/Settings'));
});

it('updates the home page setting', function () {
    $pages = Page::factory()->count(2)->create(['is_home' => false]);
    $target = $pages->first();

    $this->patch(route('admin.page.update-settings'), ['slug' => $target->slug])
        ->assertRedirect(route('admin.page.settings'));

    $this->assertDatabaseHas('pages', ['id' => $target->id, 'is_home' => true]);
});
