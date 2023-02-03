<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject' => $this->faker->sentence(5),
            'body' => $this->faker->sentence(15),
            'sender_id' => $this->faker->randomElement([1,2,3]),
            'receiver_id' => $this->faker->randomElement([1,2,3]),
            'created_at' => $this->faker->dateTime
        ];
    }
}
