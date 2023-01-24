<?php

namespace Database\Factories;

use App\Models\UserMeta;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserMetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserMeta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'address2' => $this->faker->text(255),
            'phone' => $this->faker->phoneNumber,
            'gender' => \Arr::random(['male', 'female']),
            'birthdate' => $this->faker->date,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
