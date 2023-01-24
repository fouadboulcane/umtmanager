<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Client;

use App\Models\Currency;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
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
    public function it_gets_clients_list()
    {
        $clients = Client::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.clients.index'));

        $response->assertOk()->assertSee($clients[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_client()
    {
        $data = Client::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.clients.store'), $data);

        $this->assertDatabaseHas('clients', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_client()
    {
        $client = Client::factory()->create();

        $currency = Currency::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zipcode' => $this->faker->numberBetween(0, 8388607),
            'website' => $this->faker->text(255),
            'tva_number' => $this->faker->text(255),
            'rc' => $this->faker->text(255),
            'nif' => $this->faker->text(255),
            'art' => $this->faker->text(255),
            'online_payment' => $this->faker->boolean,
            'currency_id' => $currency->id,
        ];

        $response = $this->putJson(route('api.clients.update', $client), $data);

        $data['id'] = $client->id;

        $this->assertDatabaseHas('clients', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_client()
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson(route('api.clients.destroy', $client));

        $this->assertModelMissing($client);

        $response->assertNoContent();
    }
}
