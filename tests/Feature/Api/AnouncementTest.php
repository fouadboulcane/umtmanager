<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Anouncement;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnouncementTest extends TestCase
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
    public function it_gets_anouncements_list()
    {
        $anouncements = Anouncement::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.anouncements.index'));

        $response->assertOk()->assertSee($anouncements[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_anouncement()
    {
        $data = Anouncement::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.anouncements.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('anouncements', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.anouncements.update', $anouncement),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $anouncement->id;

        $this->assertDatabaseHas('anouncements', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_anouncement()
    {
        $anouncement = Anouncement::factory()->create();

        $response = $this->deleteJson(
            route('api.anouncements.destroy', $anouncement)
        );

        $this->assertModelMissing($anouncement);

        $response->assertNoContent();
    }
}
