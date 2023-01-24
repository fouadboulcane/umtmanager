<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserMeta;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUserMetasTest extends TestCase
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
    public function it_gets_user_user_metas()
    {
        $user = User::factory()->create();
        $userMetas = UserMeta::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.user-metas.index', $user));

        $response->assertOk()->assertSee($userMetas[0]->address);
    }

    /**
     * @test
     */
    public function it_stores_the_user_user_metas()
    {
        $user = User::factory()->create();
        $data = UserMeta::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.user-metas.store', $user),
            $data
        );

        unset($data['address']);
        unset($data['address2']);
        unset($data['phone']);
        unset($data['gender']);
        unset($data['user_id']);
        unset($data['birthdate']);

        $this->assertDatabaseHas('user_metas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $userMeta = UserMeta::latest('id')->first();

        $this->assertEquals($user->id, $userMeta->user_id);
    }
}
