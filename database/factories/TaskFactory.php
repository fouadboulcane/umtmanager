<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'difficulty' => '1',
            'status' => array_rand(
                array_flip(['todo', 'ongoing', 'done', 'closed']),
                1
            ),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'project_id' => \App\Models\Project::factory(),
            'member_id' => \App\Models\User::factory(),
        ];
    }
}
