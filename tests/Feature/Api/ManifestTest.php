<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Manifest;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManifestTest extends TestCase
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
    public function it_gets_manifests_list()
    {
        $manifests = Manifest::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.manifests.index'));

        $response->assertOk()->assertSee($manifests[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_manifest()
    {
        $data = Manifest::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.manifests.store'), $data);

        unset($data['fields']);

        $this->assertDatabaseHas('manifests', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.manifests.update', $manifest),
            $data
        );

        unset($data['fields']);

        $data['id'] = $manifest->id;

        $this->assertDatabaseHas('manifests', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_manifest()
    {
        $manifest = Manifest::factory()->create();

        $response = $this->deleteJson(
            route('api.manifests.destroy', $manifest)
        );

        $this->assertModelMissing($manifest);

        $response->assertNoContent();
    }
}
