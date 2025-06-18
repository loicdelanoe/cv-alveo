<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlockType>
 */
class BlockTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->unique()->word,
            'fields' => [
                [
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                    'validation' => ['required', 'min:3'],
                ],
            ],
        ];
    }
}
