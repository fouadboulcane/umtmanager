<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Expense;

use App\Models\Project;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseControllerTest extends TestCase
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
    public function it_displays_index_view_with_expenses()
    {
        $expenses = Expense::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('expenses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.expenses.index')
            ->assertViewHas('expenses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_expense()
    {
        $response = $this->get(route('expenses.create'));

        $response->assertOk()->assertViewIs('app.expenses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_expense()
    {
        $data = Expense::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('expenses.store'), $data);

        $this->assertDatabaseHas('expenses', $data);

        $expense = Expense::latest('id')->first();

        $response->assertRedirect(route('expenses.edit', $expense));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->get(route('expenses.show', $expense));

        $response
            ->assertOk()
            ->assertViewIs('app.expenses.show')
            ->assertViewHas('expense');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->get(route('expenses.edit', $expense));

        $response
            ->assertOk()
            ->assertViewIs('app.expenses.edit')
            ->assertViewHas('expense');
    }

    /**
     * @test
     */
    public function it_updates_the_expense()
    {
        $expense = Expense::factory()->create();

        $project = Project::factory()->create();
        $user = User::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'amount' => $this->faker->randomNumber(2),
            'date' => $this->faker->date,
            'category' => 'miscellaneous_expense',
            'tax' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'tax2' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'project_id' => $project->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('expenses.update', $expense), $data);

        $data['id'] = $expense->id;

        $this->assertDatabaseHas('expenses', $data);

        $response->assertRedirect(route('expenses.edit', $expense));
    }

    /**
     * @test
     */
    public function it_deletes_the_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->delete(route('expenses.destroy', $expense));

        $response->assertRedirect(route('expenses.index'));

        $this->assertModelMissing($expense);
    }
}
