<?php

use App\Models\Block;
use App\Models\BlockType;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $this->actingAs($user);
});

it('renders the index page', function () {
    BlockType::factory()->count(3)->create();

    $this->get(route('admin.block-type.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/BlockType/Index'));
});

it('renders the create page', function () {
    $this->get(route('admin.block-type.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/BlockType/Create'));
});

it('stores a new block type and creates the Vue component', function () {
    $component = 'MyComponentTest';
    $path = resource_path("js/Components/Blocks/{$component}.vue");

    if (File::exists($path)) {
        File::delete($path);
    }

    $payload = [
        'name' => 'Hero',
        'type' => 'hero',
        'component' => $component,
        'fields' => [
            [
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'validation' => ['required'],
            ],
        ],
    ];

    $this->post(route('admin.block-type.store'), $payload)
        ->assertRedirect(route('admin.block-type.show', 'hero'));

    $this->assertDatabaseHas('block_types', [
        'type' => 'hero',
        'name' => 'Hero',
    ]);

    expect(File::exists($path))->toBeTrue();

    // Nettoyage du fichier généré
    File::delete($path);
});

it('shows a single block type', function () {
    $blockType = BlockType::factory()->create();
    Block::factory()->count(2)->create(['block_type_id' => $blockType->id]);

    $this->get(route('admin.block-type.show', $blockType->type))
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/BlockType/Show'));
});

it('deletes a block type and its blocks', function () {
    $blockType = BlockType::factory()->create();
    $blocks = Block::factory()->count(2)->create(['block_type_id' => $blockType->id]);

    $this->delete(route('admin.block-type.destroy', $blockType->type))
        ->assertRedirect(route('admin.page.index'));

    $this->assertDatabaseMissing('block_types', ['id' => $blockType->id]);

    foreach ($blocks as $block) {
        $this->assertDatabaseMissing('blocks', ['id' => $block->id]);
    }
});
