<?php

use App\Models\Block;
use App\Models\BlockType;
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
    Block::factory()->count(3)->create();
    BlockType::factory()->count(2)->create();

    $this->get(route('admin.block.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Block/Index'));
});

it('renders the create page', function () {
    $blockType = BlockType::factory()->create();

    $this->get(route('admin.block.create', $blockType->type))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Block/Create'));
});

it('stores a new block', function () {
    $blockType = BlockType::factory()->create([
        'fields' => [
            ['name' => 'title', 'type' => 'text', 'validation' => ['required']],
        ],
    ]);

    $payload = [
        'content' => ['title' => 'My Block Title'],
    ];

    $this->post(route('admin.block.store', $blockType->type), $payload)
        ->assertRedirect(route('admin.block-type.show', $blockType));

    $this->assertDatabaseHas('blocks', [
        'block_type_id' => $blockType->id,
    ]);
});

it('shows a single block', function () {
    $block = Block::factory()->create();

    $this->get(route('admin.block.show', $block))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Block/Show'));
});

it('updates a block', function () {
    $blockType = BlockType::factory()->create([
        'fields' => [
            ['name' => 'title', 'type' => 'text', 'validation' => ['required']],
        ],
    ]);

    $block = Block::factory()->create([
        'block_type_id' => $blockType->id,
        'content' => [
            'title' => 'Old Title',
        ],
    ]);

    $payload = [
        'content' => ['title' => 'Updated Title'],
    ];

    $this->patch(route('admin.block.update', $block), $payload)
        ->assertSuccessful();

    $this->assertDatabaseHas('blocks', [
        'id' => $block->id,
        'block_type_id' => $blockType->id,
        'content' => json_encode(['title' => 'Updated Title']),
    ]);
});

it('deletes a block', function () {
    $block = Block::factory()->create();
    $blockType = BlockType::factory()->create();
    $block->blockType()->associate($blockType)->save();

    $this->delete(route('admin.block.destroy', $block))
        ->assertRedirect(route('admin.block-type.show', $blockType->type));

    $this->assertDatabaseMissing('blocks', [
        'id' => $block->id,
    ]);
});

it('fetches blocks by block type', function () {
    $blockType = BlockType::factory()->create();
    Block::factory()->count(5)->create(['block_type_id' => $blockType->id]);

    $this->get(route('admin.block.get-blocks-by-type', $blockType->type))
        ->assertOk()
        ->assertJsonStructure(['data']);
});
