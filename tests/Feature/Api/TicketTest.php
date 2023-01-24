<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Ticket;

use App\Models\Client;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
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
    public function it_gets_tickets_list()
    {
        $tickets = Ticket::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tickets.index'));

        $response->assertOk()->assertSee($tickets[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_ticket()
    {
        $data = Ticket::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tickets.store'), $data);

        unset($data['title']);
        unset($data['description']);
        unset($data['type']);
        unset($data['client_id']);
        unset($data['user_id']);
        unset($data['status']);

        $this->assertDatabaseHas('tickets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_ticket()
    {
        $ticket = Ticket::factory()->create();

        $client = Client::factory()->create();
        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'type' => 'general_support',
            'status' => array_rand(array_flip(['opened', 'closed']), 1),
            'client_id' => $client->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.tickets.update', $ticket), $data);

        unset($data['title']);
        unset($data['description']);
        unset($data['type']);
        unset($data['client_id']);
        unset($data['user_id']);
        unset($data['status']);

        $data['id'] = $ticket->id;

        $this->assertDatabaseHas('tickets', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->deleteJson(route('api.tickets.destroy', $ticket));

        $this->assertModelMissing($ticket);

        $response->assertNoContent();
    }
}
