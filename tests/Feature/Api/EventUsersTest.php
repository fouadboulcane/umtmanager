<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Event;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventUsersTest extends TestCase
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
    public function it_gets_event_users()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        $event->teamMembers()->attach($user);

        $response = $this->getJson(route('api.events.users.index', $event));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_event()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.events.users.store', [$event, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $event
                ->teamMembers()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_event()
    {
        $event = Event::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.events.users.store', [$event, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $event
                ->teamMembers()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
