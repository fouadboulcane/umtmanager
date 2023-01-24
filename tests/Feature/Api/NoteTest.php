<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Note;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteTest extends TestCase
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
    public function it_gets_notes_list()
    {
        $notes = Note::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.notes.index'));

        $response->assertOk()->assertSee($notes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_note()
    {
        $data = Note::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.notes.store'), $data);

        unset($data['user_id']);
        unset($data['noteable_id']);
        unset($data['noteable_type']);

        $this->assertDatabaseHas('notes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.notes.update', $note), $data);

        unset($data['user_id']);
        unset($data['noteable_id']);
        unset($data['noteable_type']);

        $data['id'] = $note->id;

        $this->assertDatabaseHas('notes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_note()
    {
        $note = Note::factory()->create();

        $response = $this->deleteJson(route('api.notes.destroy', $note));

        $this->assertModelMissing($note);

        $response->assertNoContent();
    }
}
