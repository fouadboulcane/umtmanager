<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'symbol' => $this->faker->currencyCode,
        ];
    }
}
