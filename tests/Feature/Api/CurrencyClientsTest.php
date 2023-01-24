<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\Currency;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyClientsTest extends TestCase
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
    public function it_gets_currency_clients()
    {
        $currency = Currency::factory()->create();
        $clients = Client::factory()
            ->count(2)
            ->create([
                'currency_id' => $currency->id,
            ]);

        $response = $this->getJson(
            route('api.currencies.clients.index', $currency)
        );

        $response->assertOk()->assertSee($clients[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_currency_clients()
    {
        $currency = Currency::factory()->create();
        $data = Client::factory()
            ->make([
                'currency_id' => $currency->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.currencies.clients.store', $currency),
            $data
        );

        $this->assertDatabaseHas('clients', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $client = Client::latest('id')->first();

        $this->assertEquals($currency->id, $client->currency_id);
    }
}
