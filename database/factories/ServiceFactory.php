<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(3),
            'short_description' => $this->faker->sentence(16),
            'full_description' => $this->faker->paragraphs(4, true),
            'icon' => null,
            'image_path' => null,
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}

