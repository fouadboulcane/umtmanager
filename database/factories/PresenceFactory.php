<?php

namespace Database\Factories;

use App\Models\Presence;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Presence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'arrival_date' => $this->faker->dateTime,
            'departure_date' => $this->faker->dateTime,
            'note' => $this->faker->text,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
