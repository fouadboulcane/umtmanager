<?php

namespace Database\Factories;

use App\Models\Manifest;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManifestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manifest::class;

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
            'status' => $this->faker->boolean,
            'is_public' => $this->faker->boolean,
            'has_files' => $this->faker->boolean,
            'fields' => [],
        ];
    }
}
