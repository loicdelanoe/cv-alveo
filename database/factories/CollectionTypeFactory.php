<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CollectionType>
 */
class CollectionTypeFactory extends Factory
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
                    'label' => 'Content',
                    'name' => 'content',
                    'type' => 'text',
                    'validation' => ['required', 'min:3'],
                ],
            ],
        ];
    }
}
