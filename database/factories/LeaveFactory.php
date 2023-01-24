<?php

namespace Database\Factories;

use App\Models\Leave;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Leave::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => array_rand(
                array_flip(['casual_leave', 'maternity_leave']),
                1
            ),
            'duration' => array_rand(
                array_flip(['one_day', 'multiple_days', 'hours']),
                1
            ),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'reason' => $this->faker->text,
            'status' => $this->faker->boolean,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
