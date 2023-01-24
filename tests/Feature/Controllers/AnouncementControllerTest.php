<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Anouncement;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnouncementControllerTest extends TestCase
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
    public function it_displays_index_view_with_anouncements()
    {
        $anouncements = Anouncement::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('anouncements.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.anouncements.index')
            ->assertViewHas('anouncements');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_anouncement()
    {
        $response = $this->get(route('anouncements.create'));

        $response->assertOk()->assertViewIs('app.anouncements.create');
    }

    /**
     * @test
     */
    public function it_stores_the_anouncement()
    {
        $data = Anouncement::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('anouncements.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('anouncements', $data);

        $anouncement = Anouncement::latest('id')->first();

        $response->assertRedirect(route('anouncements.edit', $anouncement));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_anouncement()
    {
        $anouncement = Anouncement::factory()->create();

        $response = $this->get(route('anouncements.show', $anouncement));

        $response
            ->assertOk()
            ->assertViewIs('app.anouncements.show')
            ->assertViewHas('anouncement');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_anouncement()
    {
        $anouncement = Anouncement::factory()->create();

        $response = $this->get(route('anouncements.edit', $anouncement));

        $response
            ->assertOk()
            ->assertViewIs('app.anouncements.edit')
            ->assertViewHas('anouncement');
    }

    /**
     * @test
     */
    public function it_updates_the_anouncement()
    {
        $anouncement = Anouncement::factory()->create();

        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'content' => $this->faker->text,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'share_with' => 'all_members',
            'user_id' => $user->id,
        ];

        $response = $this->put(
            route('anouncements.update', $anouncement),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $anouncement->id;

        $this->assertDatabaseHas('anouncements', $data);

        $response->assertRedirect(route('anouncements.edit', $anouncement));
    }

    /**
     * @test
     */
    public function it_deletes_the_anouncement()
    {
        $anouncement = Anouncement::factory()->create();

        $response = $this->delete(route('anouncements.destroy', $anouncement));

        $response->assertRedirect(route('anouncements.index'));

        $this->assertModelMissing($anouncement);
    }
}
