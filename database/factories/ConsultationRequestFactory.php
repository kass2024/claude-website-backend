<?php

namespace Database\Factories;

use App\Models\ConsultationRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ConsultationRequest>
 */
class ConsultationRequestFactory extends Factory
{
    protected $model = ConsultationRequest::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'company' => $this->faker->optional()->company(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'country' => $this->faker->optional()->country(),
            'service_category' => $this->faker->optional()->randomElement([
                'Architecture & Construction',
                'Artificial Intelligence & Innovation',
                'Digital Services',
                'Training & E-Learning',
                'Real Estate Consulting & Investment',
                'Strategic Marketing & Business Development',
            ]),
            'consultation_type' => $this->faker->optional()->randomElement([
                'Virtual Meeting',
                'Phone Call',
                'In-Person Meeting',
            ]),
            'preferred_date' => $this->faker->optional()->date(),
            'project_summary' => $this->faker->paragraphs(2, true),
        ];
    }
}

