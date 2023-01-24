<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Event;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEventsTest extends TestCase
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
    public function it_gets_user_events()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $user->events()->attach($event);

        $response = $this->getJson(route('api.users.events.index', $user));

        $response->assertOk()->assertSee($event->title);
    }

    /**
     * @test
     */
    public function it_can_attach_events_to_user()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->postJson(
            route('api.users.events.store', [$user, $event])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->events()
                ->where('events.id', $event->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_events_from_user()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->deleteJson(
            route('api.users.events.store', [$user, $event])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->events()
                ->where('events.id', $event->id)
                ->exists()
        );
    }
}
