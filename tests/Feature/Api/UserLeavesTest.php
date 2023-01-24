<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Leave;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLeavesTest extends TestCase
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
    public function it_gets_user_leaves()
    {
        $user = User::factory()->create();
        $leaves = Leave::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.leaves.index', $user));

        $response->assertOk()->assertSee($leaves[0]->start_date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_leaves()
    {
        $user = User::factory()->create();
        $data = Leave::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.leaves.store', $user),
            $data
        );

        unset($data['status']);
        unset($data['user_id']);

        $this->assertDatabaseHas('leaves', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $leave = Leave::latest('id')->first();

        $this->assertEquals($user->id, $leave->user_id);
    }
}
