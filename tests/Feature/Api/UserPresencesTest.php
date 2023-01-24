<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPresencesTest extends TestCase
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
    public function it_gets_user_presences()
    {
        $user = User::factory()->create();
        $presences = Presence::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.presences.index', $user));

        $response->assertOk()->assertSee($presences[0]->note);
    }

    /**
     * @test
     */
    public function it_stores_the_user_presences()
    {
        $user = User::factory()->create();
        $data = Presence::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.presences.store', $user),
            $data
        );

        $this->assertDatabaseHas('presences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $presence = Presence::latest('id')->first();

        $this->assertEquals($user->id, $presence->user_id);
    }
}
