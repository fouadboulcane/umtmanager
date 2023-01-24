<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Presence;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceControllerTest extends TestCase
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
    public function it_displays_index_view_with_presences()
    {
        $presences = Presence::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('presences.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.index')
            ->assertViewHas('presences');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_presence()
    {
        $response = $this->get(route('presences.create'));

        $response->assertOk()->assertViewIs('app.presences.create');
    }

    /**
     * @test
     */
    public function it_stores_the_presence()
    {
        $data = Presence::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('presences.store'), $data);

        $this->assertDatabaseHas('presences', $data);

        $presence = Presence::latest('id')->first();

        $response->assertRedirect(route('presences.edit', $presence));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_presence()
    {
        $presence = Presence::factory()->create();

        $response = $this->get(route('presences.show', $presence));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.show')
            ->assertViewHas('presence');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_presence()
    {
        $presence = Presence::factory()->create();

        $response = $this->get(route('presences.edit', $presence));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.edit')
            ->assertViewHas('presence');
    }

    /**
     * @test
     */
    public function it_updates_the_presence()
    {
        $presence = Presence::factory()->create();

        $user = User::factory()->create();

        $data = [
            'arrival_date' => $this->faker->dateTime,
            'departure_date' => $this->faker->dateTime,
            'note' => $this->faker->text,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('presences.update', $presence), $data);

        $data['id'] = $presence->id;

        $this->assertDatabaseHas('presences', $data);

        $response->assertRedirect(route('presences.edit', $presence));
    }

    /**
     * @test
     */
    public function it_deletes_the_presence()
    {
        $presence = Presence::factory()->create();

        $response = $this->delete(route('presences.destroy', $presence));

        $response->assertRedirect(route('presences.index'));

        $this->assertModelMissing($presence);
    }
}
