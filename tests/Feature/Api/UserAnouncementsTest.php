<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Anouncement;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAnouncementsTest extends TestCase
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
    public function it_gets_user_anouncements()
    {
        $user = User::factory()->create();
        $anouncements = Anouncement::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.anouncements.index', $user)
        );

        $response->assertOk()->assertSee($anouncements[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_user_anouncements()
    {
        $user = User::factory()->create();
        $data = Anouncement::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.anouncements.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('anouncements', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $anouncement = Anouncement::latest('id')->first();

        $this->assertEquals($user->id, $anouncement->user_id);
    }
}
