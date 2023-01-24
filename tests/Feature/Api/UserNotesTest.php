<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Note;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserNotesTest extends TestCase
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
    public function it_gets_user_notes()
    {
        $user = User::factory()->create();
        $notes = Note::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.notes.index', $user));

        $response->assertOk()->assertSee($notes[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_user_notes()
    {
        $user = User::factory()->create();
        $data = Note::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.notes.store', $user),
            $data
        );

        unset($data['user_id']);
        unset($data['noteable_id']);
        unset($data['noteable_type']);

        $this->assertDatabaseHas('notes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $note = Note::latest('id')->first();

        $this->assertEquals($user->id, $note->user_id);
    }
}
