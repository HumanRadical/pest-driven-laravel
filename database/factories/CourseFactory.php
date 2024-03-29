<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paddle_product_id' => fake()->uuid(),
            'slug' => fake()->slug(),
            'tagline' => fake()->sentence(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'image' => 'image.png',
            'learnings' => fake()->words(),
        ];
    }

    public function released(Carbon $date = null)
    {
        return $this->state(
            fn ($attributes) => ['released_at' => $date ?? Carbon::now()]
        );
    }
}
