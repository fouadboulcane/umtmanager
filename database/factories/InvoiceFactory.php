<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'billing_date' => $this->faker->date,
            'due_date' => $this->faker->date,
            'tax' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'tax2' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'note' => $this->faker->text,
            'reccurent' => $this->faker->boolean,
            'status' => array_rand(
                array_flip(['paid', 'canceled', 'draft', 'late']),
                1
            ),
            'project_id' => \App\Models\Project::factory(),
            'client_id' => \App\Models\Client::factory(),
        ];
    }
}
