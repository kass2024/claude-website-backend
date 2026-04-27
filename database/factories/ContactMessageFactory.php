<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'company' => $this->faker->optional()->company(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'country' => $this->faker->optional()->country(),
            'service_interest' => $this->faker->optional()->randomElement([
                'Architecture & Construction',
                'Artificial Intelligence & Innovation',
                'Digital Services',
                'Training & E-Learning',
                'Real Estate Consulting',
                'Strategic Marketing',
                'General Inquiry',
            ]),
            'message' => $this->faker->paragraphs(2, true),
        ];
    }
}

