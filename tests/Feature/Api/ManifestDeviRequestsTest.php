<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Manifest;
use App\Models\DeviRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManifestDeviRequestsTest extends TestCase
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
    public function it_gets_manifest_devi_requests()
    {
        $manifest = Manifest::factory()->create();
        $deviRequests = DeviRequest::factory()
            ->count(2)
            ->create([
                'manifest_id' => $manifest->id,
            ]);

        $response = $this->getJson(
            route('api.manifests.devi-requests.index', $manifest)
        );

        $response->assertOk()->assertSee($deviRequests[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_manifest_devi_requests()
    {
        $manifest = Manifest::factory()->create();
        $data = DeviRequest::factory()
            ->make([
                'manifest_id' => $manifest->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.manifests.devi-requests.store', $manifest),
            $data
        );

        $this->assertDatabaseHas('devi_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $deviRequest = DeviRequest::latest('id')->first();

        $this->assertEquals($manifest->id, $deviRequest->manifest_id);
    }
}
