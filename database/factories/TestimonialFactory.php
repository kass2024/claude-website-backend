<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'quote' => $this->faker->sentence(24),
            'client_name' => $this->faker->optional()->name(),
            'client_title' => $this->faker->optional()->jobTitle(),
            'client_company' => $this->faker->optional()->company(),
            'country' => $this->faker->optional()->country(),
            'sort_order' => 0,
            'is_published' => true,
        ];
    }
}

