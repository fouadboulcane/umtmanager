<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Manifest;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManifestControllerTest extends TestCase
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
    public function it_displays_index_view_with_manifests()
    {
        $manifests = Manifest::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('manifests.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.manifests.index')
            ->assertViewHas('manifests');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_manifest()
    {
        $response = $this->get(route('manifests.create'));

        $response->assertOk()->assertViewIs('app.manifests.create');
    }

    /**
     * @test
     */
    public function it_stores_the_manifest()
    {
        $data = Manifest::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('manifests.store'), $data);

        unset($data['fields']);

        $this->assertDatabaseHas('manifests', $data);

        $manifest = Manifest::latest('id')->first();

        $response->assertRedirect(route('manifests.edit', $manifest));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_manifest()
    {
        $manifest = Manifest::factory()->create();

        $response = $this->get(route('manifests.show', $manifest));

        $response
            ->assertOk()
            ->assertViewIs('app.manifests.show')
            ->assertViewHas('manifest');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_manifest()
    {
        $manifest = Manifest::factory()->create();

        $response = $this->get(route('manifests.edit', $manifest));

        $response
            ->assertOk()
            ->assertViewIs('app.manifests.edit')
            ->assertViewHas('manifest');
    }

    /**
     * @test
     */
    public function it_updates_the_manifest()
    {
        $manifest = Manifest::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'status' => $this->faker->boolean,
            'is_public' => $this->faker->boolean,
            'has_files' => $this->faker->boolean,
            'fields' => [],
        ];

        $response = $this->put(route('manifests.update', $manifest), $data);

        unset($data['fields']);

        $data['id'] = $manifest->id;

        $this->assertDatabaseHas('manifests', $data);

        $response->assertRedirect(route('manifests.edit', $manifest));
    }

    /**
     * @test
     */
    public function it_deletes_the_manifest()
    {
        $manifest = Manifest::factory()->create();

        $response = $this->delete(route('manifests.destroy', $manifest));

        $response->assertRedirect(route('manifests.index'));

        $this->assertModelMissing($manifest);
    }
}
