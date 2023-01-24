<?php

namespace Database\Factories;

use App\Models\Anouncement;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Anouncement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->text,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'share_with' => 'all_members',
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
