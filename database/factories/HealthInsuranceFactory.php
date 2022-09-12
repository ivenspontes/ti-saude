<?php

namespace Database\Factories;

use App\Models\HealthInsurance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HealthInsurance>
 */
class HealthInsuranceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
