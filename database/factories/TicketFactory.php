<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

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
            'type' => 'general_support',
            'status' => array_rand(array_flip(['opened', 'closed']), 1),
            'client_id' => \App\Models\Client::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
