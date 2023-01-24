<?php

namespace Database\Factories;

use App\Models\SocialLink;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialLinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SocialLink::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'facebook' => $this->faker->text(255),
            'twitter' => $this->faker->text(255),
            'linkedin' => $this->faker->text(255),
            'google_plus' => $this->faker->text(255),
            'digg' => $this->faker->text(255),
            'youtube' => $this->faker->text(255),
            'pinterest' => $this->faker->text(255),
            'instagram' => $this->faker->text(255),
            'github' => $this->faker->text(255),
            'tumblr' => $this->faker->text(255),
            'tiktok' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
