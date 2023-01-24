<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\DeviRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientDeviRequestsTest extends TestCase
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
    public function it_gets_client_devi_requests()
    {
        $client = Client::factory()->create();
        $deviRequests = DeviRequest::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(
            route('api.clients.devi-requests.index', $client)
        );

        $response->assertOk()->assertSee($deviRequests[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_client_devi_requests()
    {
        $client = Client::factory()->create();
        $data = DeviRequest::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.devi-requests.store', $client),
            $data
        );

        $this->assertDatabaseHas('devi_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $deviRequest = DeviRequest::latest('id')->first();

        $this->assertEquals($client->id, $deviRequest->client_id);
    }
}
