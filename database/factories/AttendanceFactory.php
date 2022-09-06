<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,15),
            'date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'attendance_in' => $this->faker->dateTimeBetween('9:00:00', '10:00:00'),
            'attendance_out' => $this->faker->dateTimeBetween('17:00:00', '18:00:00'),
        ];
    }
}
