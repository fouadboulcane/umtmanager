<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Leave;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaveControllerTest extends TestCase
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
    public function it_displays_index_view_with_leaves()
    {
        $leaves = Leave::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('leaves.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.leaves.index')
            ->assertViewHas('leaves');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_leave()
    {
        $response = $this->get(route('leaves.create'));

        $response->assertOk()->assertViewIs('app.leaves.create');
    }

    /**
     * @test
     */
    public function it_stores_the_leave()
    {
        $data = Leave::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('leaves.store'), $data);

        unset($data['status']);
        unset($data['user_id']);

        $this->assertDatabaseHas('leaves', $data);

        $leave = Leave::latest('id')->first();

        $response->assertRedirect(route('leaves.edit', $leave));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_leave()
    {
        $leave = Leave::factory()->create();

        $response = $this->get(route('leaves.show', $leave));

        $response
            ->assertOk()
            ->assertViewIs('app.leaves.show')
            ->assertViewHas('leave');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_leave()
    {
        $leave = Leave::factory()->create();

        $response = $this->get(route('leaves.edit', $leave));

        $response
            ->assertOk()
            ->assertViewIs('app.leaves.edit')
            ->assertViewHas('leave');
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

        $response = $this->put(route('leaves.update', $leave), $data);

        unset($data['status']);
        unset($data['user_id']);

        $data['id'] = $leave->id;

        $this->assertDatabaseHas('leaves', $data);

        $response->assertRedirect(route('leaves.edit', $leave));
    }

    /**
     * @test
     */
    public function it_deletes_the_leave()
    {
        $leave = Leave::factory()->create();

        $response = $this->delete(route('leaves.destroy', $leave));

        $response->assertRedirect(route('leaves.index'));

        $this->assertModelMissing($leave);
    }
}
