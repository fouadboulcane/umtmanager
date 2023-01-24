<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
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
    public function it_gets_project_tasks()
    {
        $project = Project::factory()->create();
        $tasks = Task::factory()
            ->count(2)
            ->create([
                'project_id' => $project->id,
            ]);

        $response = $this->getJson(route('api.projects.tasks.index', $project));

        $response->assertOk()->assertSee($tasks[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_project_tasks()
    {
        $project = Project::factory()->create();
        $data = Task::factory()
            ->make([
                'project_id' => $project->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.projects.tasks.store', $project),
            $data
        );

        unset($data['member_id']);

        $this->assertDatabaseHas('tasks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $task = Task::latest('id')->first();

        $this->assertEquals($project->id, $task->project_id);
    }
}
