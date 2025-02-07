<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'date_of_birth' => $this->faker->dateTimeBetween('-18 years', '-5 years')->format('Y-m-d'),
            'father_name' => $this->faker->name,
            'mother_name' => $this->faker->name,
            'grade_id' => $this->faker->numberBetween(1, 11),
            'section_id' => $this->faker->numberBetween(1, 3),
            'enrollment_date' => $this->faker->dateTimeBetween("-18 years", "-1 year")->format('Y-m-d'),
            'status' => $this->faker->randomElement(['activo', 'inactivo', 'suspendido']),
        ];
    }
}
