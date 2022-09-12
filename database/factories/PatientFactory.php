<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phones' => [
               $this->faker->phoneNumber,
               $this->faker->phoneNumber
            ],
            'birthday' => $this->faker->date('d/m/Y'),
        ];
    }
}
