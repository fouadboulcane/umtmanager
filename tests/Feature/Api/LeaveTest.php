<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Leave;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveTest extends TestCase
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
    public function it_gets_leaves_list()
    {
        $leaves = Leave::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.leaves.index'));

        $response->assertOk()->assertSee($leaves[0]->start_date);
    }

    /**
     * @test
     */
    public function it_stores_the_leave()
    {
        $data = Leave::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.leaves.store'), $data);

        unset($data['status']);
        unset($data['user_id']);

        $this->assertDatabaseHas('leaves', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_leave()
    {
        $leave = Leave::factory()->create();

        $user = User::factory()->create();

        $data = [
            'type' => array_rand(
                array_flip(['casual_leave', 'maternity_leave']),
                1
            ),
            'duration' => array_rand(
                array_flip(['one_day', 'multiple_days', 'hours']),
                1
            ),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'reason' => $this->faker->text,
            'status' => $this->faker->boolean,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.leaves.update', $leave), $data);

        unset($data['status']);
        unset($data['user_id']);

        $data['id'] = $leave->id;

        $this->assertDatabaseHas('leaves', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_leave()
    {
        $leave = Leave::factory()->create();

        $response = $this->deleteJson(route('api.leaves.destroy', $leave));

        $this->assertModelMissing($leave);

        $response->assertNoContent();
    }
}
