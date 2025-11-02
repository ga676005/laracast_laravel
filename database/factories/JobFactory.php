<?php

namespace Database\Factories;

use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usdSalary = fake()->numberBetween(50000, 200000);
        $exchangeRate = 30; // USD to TWD exchange rate (approximate)
        $twdSalary = $usdSalary * $exchangeRate;

        return [
            'employer_id' => Employer::factory(),
            'title' => fake()->jobTitle(),
            'salary' => [
                'USD' => (string) $usdSalary,
                'TWD' => (string) $twdSalary,
            ],
        ];
    }
}
