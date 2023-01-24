<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientProjectsTest extends TestCase
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
    public function it_gets_client_projects()
    {
        $client = Client::factory()->create();
        $projects = Project::factory()
            ->count(2)
            ->create([
                'client_id' => $client->id,
            ]);

        $response = $this->getJson(
            route('api.clients.projects.index', $client)
        );

        $response->assertOk()->assertSee($projects[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_client_projects()
    {
        $client = Client::factory()->create();
        $data = Project::factory()
            ->make([
                'client_id' => $client->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clients.projects.store', $client),
            $data
        );

        unset($data['status']);

        $this->assertDatabaseHas('projects', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $project = Project::latest('id')->first();

        $this->assertEquals($client->id, $project->client_id);
    }
}
