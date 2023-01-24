<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Note;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteControllerTest extends TestCase
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
    public function it_displays_index_view_with_notes()
    {
        $notes = Note::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('notes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.notes.index')
            ->assertViewHas('notes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_note()
    {
        $response = $this->get(route('notes.create'));

        $response->assertOk()->assertViewIs('app.notes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_note()
    {
        $data = Note::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('notes.store'), $data);

        unset($data['user_id']);
        unset($data['noteable_id']);
        unset($data['noteable_type']);

        $this->assertDatabaseHas('notes', $data);

        $note = Note::latest('id')->first();

        $response->assertRedirect(route('notes.edit', $note));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_note()
    {
        $note = Note::factory()->create();

        $response = $this->get(route('notes.show', $note));

        $response
            ->assertOk()
            ->assertViewIs('app.notes.show')
            ->assertViewHas('note');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_note()
    {
        $note = Note::factory()->create();

        $response = $this->get(route('notes.edit', $note));

        $response
            ->assertOk()
            ->assertViewIs('app.notes.edit')
            ->assertViewHas('note');
    }

    /**
     * @test
     */
    public function it_updates_the_note()
    {
        $note = Note::factory()->create();

        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'user_id' => $user->id,
        ];

        $response = $this->put(route('notes.update', $note), $data);

        unset($data['user_id']);
        unset($data['noteable_id']);
        unset($data['noteable_type']);

        $data['id'] = $note->id;

        $this->assertDatabaseHas('notes', $data);

        $response->assertRedirect(route('notes.edit', $note));
    }

    /**
     * @test
     */
    public function it_deletes_the_note()
    {
        $note = Note::factory()->create();

        $response = $this->delete(route('notes.destroy', $note));

        $response->assertRedirect(route('notes.index'));

        $this->assertModelMissing($note);
    }
}
