<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Task;

use App\Models\Project;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
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
    public function it_displays_index_view_with_tasks()
    {
        $tasks = Task::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('tasks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.tasks.index')
            ->assertViewHas('tasks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_task()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertOk()->assertViewIs('app.tasks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_task()
    {
        $data = Task::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('tasks.store'), $data);

        unset($data['member_id']);

        $this->assertDatabaseHas('tasks', $data);

        $task = Task::latest('id')->first();

        $response->assertRedirect(route('tasks.edit', $task));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_task()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task));

        $response
            ->assertOk()
            ->assertViewIs('app.tasks.show')
            ->assertViewHas('task');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_task()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response
            ->assertOk()
            ->assertViewIs('app.tasks.edit')
            ->assertViewHas('task');
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

        $response = $this->put(route('tasks.update', $task), $data);

        unset($data['member_id']);

        $data['id'] = $task->id;

        $this->assertDatabaseHas('tasks', $data);

        $response->assertRedirect(route('tasks.edit', $task));
    }

    /**
     * @test
     */
    public function it_deletes_the_task()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertModelMissing($task);
    }
}
