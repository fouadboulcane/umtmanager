<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;

use App\Models\Project;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
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
    public function it_gets_tasks_list()
    {
        $tasks = Task::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.tasks.index'));

        $response->assertOk()->assertSee($tasks[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_task()
    {
        $data = Task::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.tasks.store'), $data);

        unset($data['member_id']);

        $this->assertDatabaseHas('tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_task()
    {
        $task = Task::factory()->create();

        $project = Project::factory()->create();
        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'difficulty' => '1',
            'status' => array_rand(
                array_flip(['todo', 'ongoing', 'done', 'closed']),
                1
            ),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'project_id' => $project->id,
            'member_id' => $user->id,
        ];

        $response = $this->putJson(route('api.tasks.update', $task), $data);

        unset($data['member_id']);

        $data['id'] = $task->id;

        $this->assertDatabaseHas('tasks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('api.tasks.destroy', $task));

        $this->assertModelMissing($task);

        $response->assertNoContent();
    }
}
