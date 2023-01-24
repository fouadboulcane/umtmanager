<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'amount' => $this->faker->randomNumber(2),
            'note' => $this->faker->text,
            'mode' => array_rand(
                array_flip([
                    'cash',
                    'postal_check',
                    'bank_check',
                    'bank_transfer',
                ]),
                1
            ),
            'invoice_id' => \App\Models\Invoice::factory(),
        ];
    }
}
