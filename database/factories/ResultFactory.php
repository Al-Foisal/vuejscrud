<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fake()->randomElement(Student::pluck('id')->toArray()),
            'gpa'        => fake()->randomFloat(2, 1, 5),
            'date'       => fake()->date('Y-m-d', 'now'),
        ];
    }
}