<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Block>
 */
class BlockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'block_type_id' => \App\Models\BlockType::factory()->create()->id,
            'content' => [
                'title' => $this->faker->sentence,
                'subtitle' => $this->faker->sentence,
                'content' => $this->faker->paragraph,
            ],
        ];
    }
}
