<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DeviRequest;

use App\Models\Client;
use App\Models\Manifest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviRequestControllerTest extends TestCase
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

    protected function castToJson($json)
    {
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        } elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception(
                'A valid JSON string was not provided for casting.'
            );
        }

        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_devi_requests()
    {
        $deviRequests = DeviRequest::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('devi-requests.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.devi_requests.index')
            ->assertViewHas('deviRequests');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_devi_request()
    {
        $response = $this->get(route('devi-requests.create'));

        $response->assertOk()->assertViewIs('app.devi_requests.create');
    }

    /**
     * @test
     */
    public function it_stores_the_devi_request()
    {
        $data = DeviRequest::factory()
            ->make()
            ->toArray();

        $data['content'] = json_encode($data['content']);

        $response = $this->post(route('devi-requests.store'), $data);

        $data['content'] = $this->castToJson($data['content']);

        $this->assertDatabaseHas('devi_requests', $data);

        $deviRequest = DeviRequest::latest('id')->first();

        $response->assertRedirect(route('devi-requests.edit', $deviRequest));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_devi_request()
    {
        $deviRequest = DeviRequest::factory()->create();

        $response = $this->get(route('devi-requests.show', $deviRequest));

        $response
            ->assertOk()
            ->assertViewIs('app.devi_requests.show')
            ->assertViewHas('deviRequest');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_devi_request()
    {
        $deviRequest = DeviRequest::factory()->create();

        $response = $this->get(route('devi-requests.edit', $deviRequest));

        $response
            ->assertOk()
            ->assertViewIs('app.devi_requests.edit')
            ->assertViewHas('deviRequest');
    }

    /**
     * @test
     */
    public function it_updates_the_devi_request()
    {
        $deviRequest = DeviRequest::factory()->create();

        $manifest = Manifest::factory()->create();
        $client = Client::factory()->create();
        $user = User::factory()->create();

        $data = [
            'content' => [],
            'status' => array_rand(
                array_flip(['pending', 'canceled', 'draft', 'estimated']),
                1
            ),
            'manifest_id' => $manifest->id,
            'client_id' => $client->id,
            'user_id' => $user->id,
        ];

        $data['content'] = json_encode($data['content']);

        $response = $this->put(
            route('devi-requests.update', $deviRequest),
            $data
        );

        $data['id'] = $deviRequest->id;

        $data['content'] = $this->castToJson($data['content']);

        $this->assertDatabaseHas('devi_requests', $data);

        $response->assertRedirect(route('devi-requests.edit', $deviRequest));
    }

    /**
     * @test
     */
    public function it_deletes_the_devi_request()
    {
        $deviRequest = DeviRequest::factory()->create();

        $response = $this->delete(route('devi-requests.destroy', $deviRequest));

        $response->assertRedirect(route('devi-requests.index'));

        $this->assertModelMissing($deviRequest);
    }
}
