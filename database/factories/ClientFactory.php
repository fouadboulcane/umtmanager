<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zipcode' => $this->faker->numberBetween(0, 8388607),
            'website' => $this->faker->text(255),
            'tva_number' => $this->faker->text(255),
            'rc' => $this->faker->text(255),
            'nif' => $this->faker->text(255),
            'art' => $this->faker->text(255),
            'online_payment' => $this->faker->boolean,
            'currency_id' => \App\Models\Currency::factory(),
        ];
    }
}
