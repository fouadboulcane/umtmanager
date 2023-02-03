<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
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
            'subject' => $this->faker->sentence(5),
            'body' => $this->faker->sentence(10),
            'start' => $this->faker->date,
            'startTime' => $this->faker->time,
            'end' => $this->faker->date,
            'endTime' => $this->faker->time,
            'share_with' => 'only_me',
            'organizer' => User::all()->random()->id,
            'status' => $this->faker->boolean,
            'client_id' => \App\Models\Client::all()->random()->id,
            // 'title' => $this->faker->sentence(10),
            // 'description' => $this->faker->sentence(15),
            // 'start_date' => $this->faker->dateTime,
            // 'end_date' => $this->faker->dateTime,
            // 'placement' => $this->faker->text(20),
            // 'color' => $this->faker->hexcolor,
            
        ];
    }
}
