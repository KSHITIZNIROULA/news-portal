<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $generalCategories = [
            'Politics',
            'Sports',
            'Technology',
            'Health',
            'Entertainment',
            'Business',
            'Science',
            'Education',
            'Travel',
            'Lifestyle',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($generalCategories),
        ];
    }
}