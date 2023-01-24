<?php

namespace Database\Factories;

use App\Models\DeviRequest;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeviRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => [],
            'status' => array_rand(
                array_flip(['pending', 'canceled', 'draft', 'estimated']),
                1
            ),
            'manifest_id' => \App\Models\Manifest::factory(),
            'client_id' => \App\Models\Client::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
