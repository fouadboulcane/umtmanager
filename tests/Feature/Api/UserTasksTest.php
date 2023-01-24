<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTasksTest extends TestCase
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
    public function it_gets_user_tasks()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $user->tasks2()->attach($task);

        $response = $this->getJson(route('api.users.tasks.index', $user));

        $response->assertOk()->assertSee($task->title);
    }

    /**
     * @test
     */
    public function it_can_attach_tasks_to_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->postJson(
            route('api.users.tasks.store', [$user, $task])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->tasks2()
                ->where('tasks.id', $task->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_tasks_from_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->deleteJson(
            route('api.users.tasks.store', [$user, $task])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->tasks2()
                ->where('tasks.id', $task->id)
                ->exists()
        );
    }
}
