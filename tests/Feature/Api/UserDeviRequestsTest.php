<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DeviRequest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDeviRequestsTest extends TestCase
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
    public function it_gets_user_devi_requests()
    {
        $user = User::factory()->create();
        $deviRequests = DeviRequest::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.devi-requests.index', $user)
        );

        $response->assertOk()->assertSee($deviRequests[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_devi_requests()
    {
        $user = User::factory()->create();
        $data = DeviRequest::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.devi-requests.store', $user),
            $data
        );

        $this->assertDatabaseHas('devi_requests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $deviRequest = DeviRequest::latest('id')->first();

        $this->assertEquals($user->id, $deviRequest->user_id);
    }
}
