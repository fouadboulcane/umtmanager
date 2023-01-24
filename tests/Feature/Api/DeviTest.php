<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Devi;

use App\Models\Client;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviTest extends TestCase
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
    public function it_gets_devis_list()
    {
        $devis = Devi::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.devis.index'));

        $response->assertOk()->assertSee($devis[0]->start_date);
    }

    /**
     * @test
     */
    public function it_stores_the_devi()
    {
        $data = Devi::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.devis.store'), $data);

        unset($data['status']);

        $this->assertDatabaseHas('devis', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_devi()
    {
        $devi = Devi::factory()->create();

        $client = Client::factory()->create();

        $data = [
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'tax' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'tax2' => array_rand(array_flip(['dt', 'tva_19%', 'tva_9%']), 1),
            'note' => $this->faker->text,
            'status' => array_rand(
                array_flip(['accepted', 'denied', 'draft', 'sent']),
                1
            ),
            'client_id' => $client->id,
        ];

        $response = $this->putJson(route('api.devis.update', $devi), $data);

        unset($data['status']);

        $data['id'] = $devi->id;

        $this->assertDatabaseHas('devis', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_devi()
    {
        $devi = Devi::factory()->create();

        $response = $this->deleteJson(route('api.devis.destroy', $devi));

        $this->assertModelMissing($devi);

        $response->assertNoContent();
    }
}
