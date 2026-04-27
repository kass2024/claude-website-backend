<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->slug(6),
            'excerpt' => $this->faker->sentence(24),
            'content' => $this->faker->paragraphs(8, true),
            'featured_image_path' => null,
            'category_id' => null,
            'author_id' => null,
            'published_at' => $this->faker->optional()->dateTime(),
        ];
    }
}

