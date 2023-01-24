<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskUsersTest extends TestCase
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
    public function it_gets_task_users()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $task->collabMembers()->attach($user);

        $response = $this->getJson(route('api.tasks.users.index', $task));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_task()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.tasks.users.store', [$task, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $task
                ->collabMembers()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_task()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.tasks.users.store', [$task, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $task
                ->collabMembers()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
