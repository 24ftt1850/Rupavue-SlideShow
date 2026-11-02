<?php

namespace Database\Factories;

use App\Models\GeneratedImage;
use App\Models\PhotoshootTheme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GeneratedImage>
 */
class GeneratedImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'photo_session_id' => fake()->randomNumber(),
            'theme_id' => PhotoshootTheme::factory(),
            'final_prompt_used' => fake()->sentence(),
            'generation_status' => 'success',
            'generated_photo_path' => 'photobooth/final_'.fake()->unique()->uuid().'.png',
            'is_deleted' => false,
        ];
    }

    /**
     * A generation the AI service rejected or timed out on.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'generation_status' => 'failed_timeout',
        ]);
    }

    /**
     * A photo removed by the retention cleanup.
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_deleted' => true,
        ]);
    }
}
