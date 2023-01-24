<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Payment;

use App\Models\Invoice;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_payments_list()
    {
        $payments = Payment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.payments.index'));

        $response->assertOk()->assertSee($payments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_payment()
    {
        $data = Payment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.payments.store'), $data);

        $this->assertDatabaseHas('payments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_payment()
    {
        $payment = Payment::factory()->create();

        $invoice = Invoice::factory()->create();

        $data = [
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
            'invoice_id' => $invoice->id,
        ];

        $response = $this->putJson(
            route('api.payments.update', $payment),
            $data
        );

        $data['id'] = $payment->id;

        $this->assertDatabaseHas('payments', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_payment()
    {
        $payment = Payment::factory()->create();

        $response = $this->deleteJson(route('api.payments.destroy', $payment));

        $this->assertModelMissing($payment);

        $response->assertNoContent();
    }
}
