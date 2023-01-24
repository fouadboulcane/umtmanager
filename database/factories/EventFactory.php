<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

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
            'start_date' => $this->faker->dateTime,
            'end_date' => $this->faker->dateTime,
            'placement' => $this->faker->text(20),
            'share_with' => 'only_me',
            'repeat' => $this->faker->boolean,
            'color' => $this->faker->hexcolor,
            'status' => $this->faker->boolean,
            'user_id' => \App\Models\User::factory(),
            'client_id' => \App\Models\Client::factory(),
        ];
    }
}
