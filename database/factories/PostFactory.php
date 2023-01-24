<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->text,
            'type' => array_rand(array_flip(['help', 'base_knowledge']), 1),
            'status' => array_rand(array_flip(['active', 'inactive']), 1),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
