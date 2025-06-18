<?php

namespace Database\Seeders;

use App\Models\BlockType;
use Illuminate\Database\Seeder;

class BlockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlockType::factory()->create([
            'name' => 'Hero',
            'type' => 'hero',
            'fields' => [
                [
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                    'validation' => ['required', 'min:3'],
                ],
                [
                    'label' => 'Subtitle',
                    'name' => 'subtitle',
                    'type' => 'text',
                    'validation' => ['required', 'min:3'],
                ],
                [
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'textarea',
                    'validation' => ['required', 'max:255'],
                ],
            ],
        ]);

        BlockType::factory()->create([
            'name' => 'Rich Text',
            'type' => 'rich-text',
            'fields' => [
                [
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'textarea',
                    'validation' => ['required'],
                ],
            ],
        ]);

        BlockType::factory()->create([
            'name' => 'Duo Image',
            'type' => 'duo-image',
            'fields' => [
                [
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                    'validation' => ['required', 'string'],
                ],
                [
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'markdown',
                    'validation' => ['required', 'string'],
                ],
                [
                    'label' => 'Buttons',
                    'name' => 'buttons',
                    'type' => 'repeater',
                    'validation' => ['required'],
                    'repeaterFields' => [
                        [
                            'label' => 'Label',
                            'name' => 'label',
                            'type' => 'text',
                        ],
                        [
                            'label' => 'Href',
                            'name' => 'href',
                            'type' => 'text',
                        ],
                    ],
                ],
                [
                    'label' => 'Image',
                    'name' => 'image',
                    'type' => 'image',
                    'validation' => ['required'],
                ],
            ],
        ]);
    }
}
