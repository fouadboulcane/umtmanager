<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Event;

use App\Models\Client;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_events()
    {
        $events = Event::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('events.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.events.index')
            ->assertViewHas('events');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_event()
    {
        $response = $this->get(route('events.create'));

        $response->assertOk()->assertViewIs('app.events.create');
    }

    /**
     * @test
     */
    public function it_stores_the_event()
    {
        $data = Event::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('events.store'), $data);

        $this->assertDatabaseHas('events', $data);

        $event = Event::latest('id')->first();

        $response->assertRedirect(route('events.edit', $event));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_event()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response
            ->assertOk()
            ->assertViewIs('app.events.show')
            ->assertViewHas('event');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_event()
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.edit', $event));

        $response
            ->assertOk()
            ->assertViewIs('app.events.edit')
            ->assertViewHas('event');
    }

    /**
     * @test
     */
    public function it_updates_the_event()
    {
        $event = Event::factory()->create();

        $user = User::factory()->create();
        $client = Client::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'start_date' => $this->faker->dateTime,
            'end_date' => $this->faker->dateTime,
            'placement' => $this->faker->text(20),
            'share_with' => 'only_me',
            'repeat' => $this->faker->boolean,
            'color' => $this->faker->hexcolor,
            'status' => $this->faker->boolean,
            'user_id' => $user->id,
            'client_id' => $client->id,
        ];

        $response = $this->put(route('events.update', $event), $data);

        $data['id'] = $event->id;

        $this->assertDatabaseHas('events', $data);

        $response->assertRedirect(route('events.edit', $event));
    }

    /**
     * @test
     */
    public function it_deletes_the_event()
    {
        $event = Event::factory()->create();

        $response = $this->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));

        $this->assertModelMissing($event);
    }
}
