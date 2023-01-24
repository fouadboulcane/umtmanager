<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'sort' => $this->faker->randomNumber(0),
            'type' => array_rand(array_flip(['help', 'base_knowledge']), 1),
            'status' => array_rand(array_flip(['active', 'inactive']), 1),
        ];
    }
}
