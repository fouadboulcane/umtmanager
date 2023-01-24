<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeamMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job_title' => $this->faker->text(255),
            'salary' => $this->faker->text(255),
            'conditions' => $this->faker->text(255),
            'n_ss' => $this->faker->randomNumber(0),
            'recruitment_date' => $this->faker->date,
            'send_info' => $this->faker->boolean,
        ];
    }
}
