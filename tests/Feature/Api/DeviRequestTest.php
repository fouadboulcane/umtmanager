<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeviRequest;

use App\Models\Client;
use App\Models\Manifest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviRequestTest extends TestCase
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
    public function it_gets_devi_requests_list()
    {
        $deviRequests = DeviRequest::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.devi-requests.index'));

        $response->assertOk()->assertSee($deviRequests[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_devi_request()
    {
        $data = DeviRequest::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.devi-requests.store'), $data);

        $this->assertDatabaseHas('devi_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_devi_request()
    {
        $deviRequest = DeviRequest::factory()->create();

        $manifest = Manifest::factory()->create();
        $client = Client::factory()->create();
        $user = User::factory()->create();

        $data = [
            'content' => [],
            'status' => array_rand(
                array_flip(['pending', 'canceled', 'draft', 'estimated']),
                1
            ),
            'manifest_id' => $manifest->id,
            'client_id' => $client->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.devi-requests.update', $deviRequest),
            $data
        );

        $data['id'] = $deviRequest->id;

        $this->assertDatabaseHas('devi_requests', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_devi_request()
    {
        $deviRequest = DeviRequest::factory()->create();

        $response = $this->deleteJson(
            route('api.devi-requests.destroy', $deviRequest)
        );

        $this->assertModelMissing($deviRequest);

        $response->assertNoContent();
    }
}
