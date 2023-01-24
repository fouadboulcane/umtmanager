<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Payment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoicePaymentsTest extends TestCase
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
    public function it_gets_invoice_payments()
    {
        $invoice = Invoice::factory()->create();
        $payments = Payment::factory()
            ->count(2)
            ->create([
                'invoice_id' => $invoice->id,
            ]);

        $response = $this->getJson(
            route('api.invoices.payments.index', $invoice)
        );

        $response->assertOk()->assertSee($payments[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_invoice_payments()
    {
        $invoice = Invoice::factory()->create();
        $data = Payment::factory()
            ->make([
                'invoice_id' => $invoice->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.invoices.payments.store', $invoice),
            $data
        );

        $this->assertDatabaseHas('payments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $payment = Payment::latest('id')->first();

        $this->assertEquals($invoice->id, $payment->invoice_id);
    }
}
