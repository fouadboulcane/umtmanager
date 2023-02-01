<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->sentence(15),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'status' => array_rand(
                array_flip(['todo', 'ongoing', 'done', 'closed']),
                1
            ),
            'client_id' => \App\Models\Client::factory(),
        ];
    }
}
