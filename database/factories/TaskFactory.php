<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(199),
            'status' => $this->faker->randomElement(['completed', 'incomplete']),
            'category_id' => collect(Category::all())->random()->id
        ];
    }
}
