<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Project;
use App\Models\Invoice;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectInvoicesTest extends TestCase
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
    public function it_gets_project_invoices()
    {
        $project = Project::factory()->create();
        $invoices = Invoice::factory()
            ->count(2)
            ->create([
                'project_id' => $project->id,
            ]);

        $response = $this->getJson(
            route('api.projects.invoices.index', $project)
        );

        $response->assertOk()->assertSee($invoices[0]->billing_date);
    }

    /**
     * @test
     */
    public function it_stores_the_project_invoices()
    {
        $project = Project::factory()->create();
        $data = Invoice::factory()
            ->make([
                'project_id' => $project->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.projects.invoices.store', $project),
            $data
        );

        $this->assertDatabaseHas('invoices', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $invoice = Invoice::latest('id')->first();

        $this->assertEquals($project->id, $invoice->project_id);
    }
}
