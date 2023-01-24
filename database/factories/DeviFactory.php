<?php

namespace Database\Factories;

use App\Models\Devi;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Devi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'tax' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'tax2' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'note' => $this->faker->text,
            'status' => array_rand(
                array_flip(['accepted', 'denied', 'draft', 'sent']),
                1
            ),
            'client_id' => \App\Models\Client::factory(),
        ];
    }
}
