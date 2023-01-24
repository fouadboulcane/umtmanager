<?php

namespace Database\Factories;

use App\Models\Note;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

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
            'user_id' => \App\Models\User::factory(),
            'noteable_type' => $this->faker->randomElement([
                \App\Models\Client::class,
                \App\Models\Project::class,
            ]),
            'noteable_id' => function (array $item) {
                return app($item['noteable_type'])->factory();
            },
        ];
    }
}
