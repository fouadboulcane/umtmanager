<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\Ticket;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTicketsTest extends TestCase
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
    public function it_gets_client_tickets()
    {
        $client = Client::factory()->create();
        $tickets = Ticket::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(route('api.clients.tickets.index', $client));

        $response->assertOk()->assertSee($tickets[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_client_tickets()
    {
        $client = Client::factory()->create();
        $data = Ticket::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.tickets.store', $client),
            $data
        );

        unset($data['title']);
        unset($data['description']);
        unset($data['type']);
        unset($data['client_id']);
        unset($data['user_id']);
        unset($data['status']);

        $this->assertDatabaseHas('tickets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $ticket = Ticket::latest('id')->first();

        $this->assertEquals($client->id, $ticket->client_id);
    }
}
