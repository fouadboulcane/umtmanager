<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Devi;
use App\Models\Client;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientDevisTest extends TestCase
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
    public function it_gets_client_devis()
    {
        $client = Client::factory()->create();
        $devis = Devi::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(route('api.clients.devis.index', $client));

        $response->assertOk()->assertSee($devis[0]->start_date);
    }

    /**
     * @test
     */
    public function it_stores_the_client_devis()
    {
        $client = Client::factory()->create();
        $data = Devi::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.devis.store', $client),
            $data
        );

        unset($data['status']);

        $this->assertDatabaseHas('devis', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $devi = Devi::latest('id')->first();

        $this->assertEquals($client->id, $devi->client_id);
    }
}
