<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attendance_id' => $this->faker->numberBetween(1,30),
            'rest_in' => $this->faker->dateTimeBetween('12:00:00', '13:00:00'),
            'rest_out' => $this->faker->dateTimeBetween('13:00:00', '14:00:00'),
        ];
    }
}
