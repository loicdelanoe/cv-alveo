<?php

namespace Database\Factories;

use App\Models\CollectionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Collection>
 */
class CollectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'status' => 'published',
            'content' => ['content' => 'Contenu de test'],
            'collection_type_id' => CollectionType::factory()->create()->id,
        ];
    }
}
