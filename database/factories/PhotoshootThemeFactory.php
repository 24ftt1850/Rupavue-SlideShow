<?php

namespace Database\Factories;

use App\Models\PhotoshootTheme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PhotoshootTheme>
 */
class PhotoshootThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'theme_name' => fake()->unique()->words(2, true),
            'description' => fake()->sentence(),
            'prompt_prefix' => fake()->sentence(),
            'is_active' => true,
        ];
    }

    /**
     * A theme that has been switched off in the admin.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
