<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recette>
 */
class RecetteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->sentence(3),
            'content'=>$this->faker->paragraph(15),
            'image'=>$this->faker->imageUrl(640, 480, 'food'),
            'category_id'=>\App\Models\Category::inRandomOrder()->first()->id
        ];
    }
}
