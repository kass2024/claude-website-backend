<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(4),
            'category' => $this->faker->randomElement([
                'Architectural Design',
                'AI & Automation Projects',
                'Digital Platforms',
            ]),
            'client_name' => $this->faker->company(),
            'country' => $this->faker->randomElement(['Canada', 'Rwanda']),
            'short_description' => $this->faker->sentence(18),
            'full_description' => $this->faker->paragraphs(5, true),
            'cover_image_path' => null,
            'gallery_paths' => [],
            'completion_date' => $this->faker->optional()->date(),
            'is_published' => true,
        ];
    }
}

